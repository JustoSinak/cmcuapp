<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * Cache tags for organized cache management
     */
    const TAGS = [
        'patients' => 'patients',
        'factures' => 'factures',
        'consultations' => 'consultations',
        'users' => 'users',
        'dashboard' => 'dashboard',
        'stats' => 'stats'
    ];

    /**
     * Cache TTL configurations (in seconds)
     */
    const TTL = [
        'short' => 300,    // 5 minutes
        'medium' => 1800,  // 30 minutes
        'long' => 3600,    // 1 hour
        'daily' => 86400,  // 24 hours
    ];

    /**
     * Remember cache with tags and automatic invalidation
     */
    public function remember(string $key, string $tag, int $ttl, callable $callback)
    {
        try {
            if (config('cache.default') === 'redis') {
                return Cache::tags([$tag])->remember($key, $ttl, $callback);
            }
            
            return Cache::remember($key, $ttl, $callback);
        } catch (\Exception $e) {
            Log::warning('Cache operation failed', [
                'key' => $key,
                'tag' => $tag,
                'error' => $e->getMessage()
            ]);
            
            // Fallback to direct execution if cache fails
            return $callback();
        }
    }

    /**
     * Flush cache by tag
     */
    public function flushTag(string $tag): bool
    {
        try {
            if (config('cache.default') === 'redis') {
                Cache::tags([$tag])->flush();
                return true;
            }
            
            // For non-Redis cache, we need to manually track keys
            $this->flushTaggedKeys($tag);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Cache flush failed', [
                'tag' => $tag,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get cache statistics
     */
    public function getStats(): array
    {
        try {
            if (config('cache.default') === 'redis') {
                $redis = Redis::connection();
                $info = $redis->info('memory');
                
                return [
                    'driver' => 'redis',
                    'memory_used' => $info['used_memory_human'] ?? 'N/A',
                    'memory_peak' => $info['used_memory_peak_human'] ?? 'N/A',
                    'keys_count' => $redis->dbsize(),
                    'hit_rate' => $this->calculateHitRate(),
                ];
            }
            
            return [
                'driver' => config('cache.default'),
                'memory_used' => 'N/A',
                'memory_peak' => 'N/A',
                'keys_count' => 'N/A',
                'hit_rate' => 'N/A',
            ];
            
        } catch (\Exception $e) {
            Log::error('Failed to get cache stats', ['error' => $e->getMessage()]);
            return ['error' => 'Unable to retrieve cache statistics'];
        }
    }

    /**
     * Warm up critical caches
     */
    public function warmUp(): void
    {
        try {
            // Warm up dashboard stats
            $this->remember('dashboard_stats', self::TAGS['dashboard'], self::TTL['medium'], function () {
                return [
                    'patients_count' => \App\Models\Patient::count(),
                    'factures_count' => \App\Models\Facture::count(),
                    'consultations_today' => \App\Models\Consultation::whereDate('created_at', today())->count(),
                ];
            });

            // Warm up user statistics
            $this->remember('user_stats', self::TAGS['users'], self::TTL['long'], function () {
                return [
                    'total_users' => \App\Models\User::count(),
                    'active_users' => \App\Models\User::where('last_login_at', '>=', now()->subDays(30))->count(),
                ];
            });

            Log::info('Cache warm-up completed successfully');
            
        } catch (\Exception $e) {
            Log::error('Cache warm-up failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Clear all application caches
     */
    public function clearAll(): void
    {
        try {
            foreach (self::TAGS as $tag) {
                $this->flushTag($tag);
            }
            
            // Clear Laravel's built-in caches
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
            
            Log::info('All caches cleared successfully');
            
        } catch (\Exception $e) {
            Log::error('Failed to clear all caches', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Calculate cache hit rate (Redis only)
     */
    private function calculateHitRate(): string
    {
        try {
            if (config('cache.default') === 'redis') {
                $redis = Redis::connection();
                $info = $redis->info('stats');
                
                $hits = $info['keyspace_hits'] ?? 0;
                $misses = $info['keyspace_misses'] ?? 0;
                $total = $hits + $misses;
                
                if ($total > 0) {
                    $hitRate = ($hits / $total) * 100;
                    return number_format($hitRate, 2) . '%';
                }
            }
            
            return 'N/A';
            
        } catch (\Exception $e) {
            return 'Error';
        }
    }

    /**
     * Manually flush tagged keys for non-Redis cache drivers
     */
    private function flushTaggedKeys(string $tag): void
    {
        // This is a simplified implementation
        // In production, you might want to maintain a registry of tagged keys
        $patterns = [
            'patients' => ['patients_*', 'patient_*'],
            'factures' => ['factures_*', 'facture_*'],
            'consultations' => ['consultations_*', 'consultation_*'],
            'dashboard' => ['dashboard_*'],
            'stats' => ['*_stats', 'stats_*'],
        ];

        if (isset($patterns[$tag])) {
            foreach ($patterns[$tag] as $pattern) {
                // Note: This is a basic implementation
                // For file-based cache, you'd need to scan the cache directory
                Cache::forget($pattern);
            }
        }
    }
}
