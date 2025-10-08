<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for performance optimization.
     */
    public function up(): void
    {
        // Add indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('login', 'idx_users_login');
            $table->index('created_at', 'idx_users_created_at');
            $table->index(['login', 'password'], 'idx_users_auth');
        });

        // Add indexes for patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->index('created_at', 'idx_patients_created_at');
            $table->index('updated_at', 'idx_patients_updated_at');
            $table->index(['nom', 'prenom'], 'idx_patients_name');
        });

        // Add indexes for consultations table
        Schema::table('consultations', function (Blueprint $table) {
            $table->index('patient_id', 'idx_consultations_patient_id');
            $table->index('user_id', 'idx_consultations_user_id');
            $table->index('created_at', 'idx_consultations_created_at');
            $table->index(['patient_id', 'created_at'], 'idx_consultations_patient_date');
        });

        // Add indexes for events table
        Schema::table('events', function (Blueprint $table) {
            $table->index('user_id', 'idx_events_user_id');
            $table->index('created_at', 'idx_events_created_at');
            $table->index(['user_id', 'created_at'], 'idx_events_user_date');
        });

        // Add indexes for produits table
        Schema::table('produits', function (Blueprint $table) {
            $table->index('nom', 'idx_produits_nom');
            $table->index('type', 'idx_produits_type');
            $table->index(['type', 'nom'], 'idx_produits_type_nom');
        });

        // Add indexes for factures table if it exists
        if (Schema::hasTable('factures')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->index('patient_id', 'idx_factures_patient_id');
                $table->index('created_at', 'idx_factures_created_at');
                $table->index(['patient_id', 'created_at'], 'idx_factures_patient_date');
            });
        }

        // Add indexes for chambres table if it exists
        if (Schema::hasTable('chambres')) {
            Schema::table('chambres', function (Blueprint $table) {
                $table->index('status', 'idx_chambres_status');
                $table->index('numero', 'idx_chambres_numero');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_login');
            $table->dropIndex('idx_users_created_at');
            $table->dropIndex('idx_users_auth');
        });

        // Drop indexes for patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex('idx_patients_created_at');
            $table->dropIndex('idx_patients_updated_at');
            $table->dropIndex('idx_patients_name');
        });

        // Drop indexes for consultations table
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropIndex('idx_consultations_patient_id');
            $table->dropIndex('idx_consultations_user_id');
            $table->dropIndex('idx_consultations_created_at');
            $table->dropIndex('idx_consultations_patient_date');
        });

        // Drop indexes for events table
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('idx_events_user_id');
            $table->dropIndex('idx_events_created_at');
            $table->dropIndex('idx_events_user_date');
        });

        // Drop indexes for produits table
        Schema::table('produits', function (Blueprint $table) {
            $table->dropIndex('idx_produits_nom');
            $table->dropIndex('idx_produits_type');
            $table->dropIndex('idx_produits_type_nom');
        });

        // Drop indexes for factures table if it exists
        if (Schema::hasTable('factures')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->dropIndex('idx_factures_patient_id');
                $table->dropIndex('idx_factures_created_at');
                $table->dropIndex('idx_factures_patient_date');
            });
        }

        // Drop indexes for chambres table if it exists
        if (Schema::hasTable('chambres')) {
            Schema::table('chambres', function (Blueprint $table) {
                $table->dropIndex('idx_chambres_status');
                $table->dropIndex('idx_chambres_numero');
            });
        }
    }
};
