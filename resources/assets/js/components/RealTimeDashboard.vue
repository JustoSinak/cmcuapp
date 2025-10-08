<template>
  <div class="real-time-dashboard">
    <!-- Real-time Statistics Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="stat-card patients-card">
          <div class="stat-icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="stat-content">
            <h3>{{ stats.patients_count }}</h3>
            <p>Total Patients</p>
            <small class="text-success" v-if="stats.patients_today > 0">
              +{{ stats.patients_today }} today
            </small>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-card consultations-card">
          <div class="stat-icon">
            <i class="fas fa-stethoscope"></i>
          </div>
          <div class="stat-content">
            <h3>{{ stats.consultations_today }}</h3>
            <p>Consultations Today</p>
            <small class="text-info">
              {{ stats.active_consultations }} active
            </small>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-card revenue-card">
          <div class="stat-icon">
            <i class="fas fa-euro-sign"></i>
          </div>
          <div class="stat-content">
            <h3>{{ formatCurrency(stats.revenue_today) }}</h3>
            <p>Revenue Today</p>
            <small class="text-success">
              {{ formatCurrency(stats.revenue_month) }} this month
            </small>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-card online-card">
          <div class="stat-icon">
            <i class="fas fa-wifi"></i>
          </div>
          <div class="stat-content">
            <h3>{{ onlineUsers.length }}</h3>
            <p>Users Online</p>
            <small class="text-muted">
              Last updated: {{ lastUpdate }}
            </small>
          </div>
        </div>
      </div>
    </div>

    <!-- Real-time Activity Feed -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fas fa-activity text-primary"></i>
              Real-time Activity
            </h5>
            <div class="connection-status">
              <span class="badge" :class="connectionStatusClass">
                <i class="fas fa-circle"></i>
                {{ connectionStatus }}
              </span>
            </div>
          </div>
          <div class="card-body">
            <div class="activity-feed" ref="activityFeed">
              <div 
                v-for="activity in recentActivities" 
                :key="activity.id"
                class="activity-item"
                :class="activity.type"
              >
                <div class="activity-icon">
                  <i :class="getActivityIcon(activity.type)"></i>
                </div>
                <div class="activity-content">
                  <div class="activity-message">{{ activity.message }}</div>
                  <div class="activity-time">{{ formatTime(activity.timestamp) }}</div>
                </div>
              </div>
              
              <div v-if="recentActivities.length === 0" class="text-center text-muted py-4">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <p>Waiting for real-time updates...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <!-- Online Users -->
        <div class="card mb-3">
          <div class="card-header">
            <h6 class="mb-0">
              <i class="fas fa-users text-success"></i>
              Online Users
            </h6>
          </div>
          <div class="card-body">
            <div class="online-users-list">
              <div 
                v-for="user in onlineUsers" 
                :key="user.id"
                class="online-user-item"
              >
                <div class="user-avatar">
                  <img :src="user.avatar || '/images/default-avatar.png'" :alt="user.name">
                  <span class="online-indicator"></span>
                </div>
                <div class="user-info">
                  <div class="user-name">{{ user.name }}</div>
                  <div class="user-role">{{ user.role }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">
              <i class="fas fa-bolt text-warning"></i>
              Quick Actions
            </h6>
          </div>
          <div class="card-body">
            <div class="quick-actions">
              <button class="btn btn-primary btn-sm btn-block mb-2" @click="refreshStats">
                <i class="fas fa-sync-alt"></i>
                Refresh Statistics
              </button>
              <button class="btn btn-success btn-sm btn-block mb-2" @click="exportReport">
                <i class="fas fa-download"></i>
                Export Report
              </button>
              <button class="btn btn-info btn-sm btn-block" @click="toggleNotifications">
                <i class="fas" :class="notificationsEnabled ? 'fa-bell-slash' : 'fa-bell'"></i>
                {{ notificationsEnabled ? 'Disable' : 'Enable' }} Notifications
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RealTimeDashboard',
  
  data() {
    return {
      stats: {
        patients_count: 0,
        patients_today: 0,
        consultations_today: 0,
        active_consultations: 0,
        revenue_today: 0,
        revenue_month: 0,
      },
      recentActivities: [],
      onlineUsers: [],
      connectionStatus: 'Connecting...',
      lastUpdate: '',
      notificationsEnabled: true,
      echo: null,
    };
  },
  
  computed: {
    connectionStatusClass() {
      return {
        'badge-success': this.connectionStatus === 'Connected',
        'badge-warning': this.connectionStatus === 'Connecting...',
        'badge-danger': this.connectionStatus === 'Disconnected',
      };
    },
  },
  
  mounted() {
    this.initializeRealTime();
    this.loadInitialData();
    this.startPeriodicUpdates();
  },
  
  beforeDestroy() {
    if (this.echo) {
      this.echo.disconnect();
    }
  },
  
  methods: {
    async initializeRealTime() {
      try {
        // Initialize Laravel Echo for WebSocket connections
        this.echo = new Echo({
          broadcaster: 'pusher',
          key: process.env.MIX_PUSHER_APP_KEY,
          cluster: process.env.MIX_PUSHER_APP_CLUSTER,
          encrypted: true,
          auth: {
            headers: {
              Authorization: `Bearer ${this.getAuthToken()}`,
            },
          },
        });
        
        // Listen for hospital-wide updates
        this.echo.private('hospital.updates')
          .listen('.patient.updated', (e) => {
            this.handlePatientUpdate(e);
          });
          
        this.echo.private('hospital.consultations')
          .listen('.consultation.created', (e) => {
            this.handleConsultationCreated(e);
          });
          
        // Listen for presence channel (online users)
        this.echo.join('hospital.presence')
          .here((users) => {
            this.onlineUsers = users;
          })
          .joining((user) => {
            this.onlineUsers.push(user);
            this.addActivity('user_joined', `${user.name} joined the system`);
          })
          .leaving((user) => {
            this.onlineUsers = this.onlineUsers.filter(u => u.id !== user.id);
            this.addActivity('user_left', `${user.name} left the system`);
          });
          
        this.connectionStatus = 'Connected';
        
      } catch (error) {
        console.error('Failed to initialize real-time connection:', error);
        this.connectionStatus = 'Disconnected';
      }
    },
    
    async loadInitialData() {
      try {
        const response = await axios.get('/api/dashboard/stats');
        this.stats = response.data.data;
        this.lastUpdate = this.formatTime(new Date());
      } catch (error) {
        console.error('Failed to load initial data:', error);
      }
    },
    
    startPeriodicUpdates() {
      // Update statistics every 30 seconds
      setInterval(() => {
        this.refreshStats();
      }, 30000);
    },
    
    async refreshStats() {
      try {
        const response = await axios.get('/api/dashboard/stats');
        this.stats = response.data.data;
        this.lastUpdate = this.formatTime(new Date());
      } catch (error) {
        console.error('Failed to refresh stats:', error);
      }
    },
    
    handlePatientUpdate(event) {
      const message = `Patient ${event.patient.nom} ${event.patient.prenom} was ${event.update_type}`;
      this.addActivity('patient_updated', message, event.timestamp);
      
      // Update patient count if it's a new patient
      if (event.update_type === 'created') {
        this.stats.patients_count++;
        this.stats.patients_today++;
      }
      
      this.showNotification('Patient Updated', message);
    },
    
    handleConsultationCreated(event) {
      const message = `New consultation for ${event.patient.name} by Dr. ${event.doctor.name}`;
      this.addActivity('consultation_created', message, event.timestamp);
      
      this.stats.consultations_today++;
      this.stats.active_consultations++;
      
      this.showNotification('New Consultation', message);
    },
    
    addActivity(type, message, timestamp = null) {
      const activity = {
        id: Date.now() + Math.random(),
        type,
        message,
        timestamp: timestamp || new Date().toISOString(),
      };
      
      this.recentActivities.unshift(activity);
      
      // Keep only last 50 activities
      if (this.recentActivities.length > 50) {
        this.recentActivities = this.recentActivities.slice(0, 50);
      }
      
      // Auto-scroll to top of activity feed
      this.$nextTick(() => {
        if (this.$refs.activityFeed) {
          this.$refs.activityFeed.scrollTop = 0;
        }
      });
    },
    
    getActivityIcon(type) {
      const icons = {
        patient_updated: 'fas fa-user-edit text-primary',
        consultation_created: 'fas fa-stethoscope text-success',
        user_joined: 'fas fa-sign-in-alt text-info',
        user_left: 'fas fa-sign-out-alt text-muted',
      };
      
      return icons[type] || 'fas fa-info-circle text-secondary';
    },
    
    formatTime(timestamp) {
      return new Date(timestamp).toLocaleTimeString();
    },
    
    formatCurrency(amount) {
      return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
      }).format(amount || 0);
    },
    
    showNotification(title, message) {
      if (!this.notificationsEnabled) return;
      
      if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(title, {
          body: message,
          icon: '/favicon.ico',
        });
      }
    },
    
    toggleNotifications() {
      if (!this.notificationsEnabled) {
        if ('Notification' in window) {
          Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
              this.notificationsEnabled = true;
            }
          });
        }
      } else {
        this.notificationsEnabled = false;
      }
    },
    
    async exportReport() {
      try {
        const response = await axios.get('/api/dashboard/export-report', {
          responseType: 'blob',
        });
        
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `dashboard-report-${new Date().toISOString().split('T')[0]}.pdf`);
        document.body.appendChild(link);
        link.click();
        link.remove();
        
      } catch (error) {
        console.error('Failed to export report:', error);
      }
    },
    
    getAuthToken() {
      return document.querySelector('meta[name="api-token"]')?.getAttribute('content') || '';
    },
  },
};
</script>

<style scoped>
.real-time-dashboard {
  padding: 20px;
}

.stat-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  transition: transform 0.2s;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-icon {
  font-size: 2.5rem;
  margin-right: 15px;
  opacity: 0.8;
}

.patients-card .stat-icon { color: #007bff; }
.consultations-card .stat-icon { color: #28a745; }
.revenue-card .stat-icon { color: #ffc107; }
.online-card .stat-icon { color: #17a2b8; }

.stat-content h3 {
  margin: 0;
  font-size: 2rem;
  font-weight: bold;
}

.stat-content p {
  margin: 0;
  color: #6c757d;
  font-size: 0.9rem;
}

.activity-feed {
  max-height: 400px;
  overflow-y: auto;
}

.activity-item {
  display: flex;
  align-items: flex-start;
  padding: 10px 0;
  border-bottom: 1px solid #f1f1f1;
}

.activity-item:last-child {
  border-bottom: none;
}

.activity-icon {
  margin-right: 10px;
  font-size: 1.2rem;
}

.activity-content {
  flex: 1;
}

.activity-message {
  font-size: 0.9rem;
  margin-bottom: 2px;
}

.activity-time {
  font-size: 0.8rem;
  color: #6c757d;
}

.online-user-item {
  display: flex;
  align-items: center;
  padding: 8px 0;
}

.user-avatar {
  position: relative;
  margin-right: 10px;
}

.user-avatar img {
  width: 32px;
  height: 32px;
  border-radius: 50%;
}

.online-indicator {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 10px;
  height: 10px;
  background: #28a745;
  border: 2px solid white;
  border-radius: 50%;
}

.user-name {
  font-size: 0.9rem;
  font-weight: 500;
}

.user-role {
  font-size: 0.8rem;
  color: #6c757d;
}

.connection-status .badge {
  font-size: 0.8rem;
}

.quick-actions .btn {
  text-align: left;
}
</style>
