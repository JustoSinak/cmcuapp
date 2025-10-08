<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PerformanceMonitorCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'performance:monitor {--report : Generate performance report}';

    /**
     * The console command description.
     */
    protected $description = 'Monitor application performance and generate reports';

    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Starting performance monitoring...');

        if ($this->option('report')) {
            $this->generatePerformanceReport();
        } else {
            $this->runPerformanceChecks();
        }

        $this->info('✅ Performance monitoring completed!');
    }

    /**
     * Run performance checks
     */
    private function runPerformanceChecks(): void
    {
        $this->info('Running performance checks...');

        // Check database performance
        $this->checkDatabasePerformance();

        // Check cache performance
        $this->checkCachePerformance();

        // Check storage performance
        $this->checkStoragePerformance();

        // Check memory usage
        $this->checkMemoryUsage();
    }

    /**
     * Generate comprehensive performance report
     */
    private function generatePerformanceReport(): void
    {
        $this->info('Generating performance report...');

        $report = [
            'timestamp' => now()->toISOString(),
            'database' => $this->getDatabaseStats(),
            'cache' => $this->getCacheStats(),
            'storage' => $this->getStorageStats(),
            'memory' => $this->getMemoryStats(),
            'application' => $this->getApplicationStats(),
        ];

        // Save report to storage
        $filename = 'performance_reports/report_' . now()->format('Y-m-d_H-i-s') . '.json';
        Storage::put($filename, json_encode($report, JSON_PRETTY_PRINT));

        $this->info("📊 Performance report saved to: {$filename}");
        $this->displayReportSummary($report);
    }

    /**
     * Check database performance
     */
    private function checkDatabasePerformance(): void
    {
        $this->line('🗄️  Checking database performance...');

        try {
            $start = microtime(true);
            DB::select('SELECT 1');
            $connectionTime = (microtime(true) - $start) * 1000;

            if ($connectionTime > 100) {
                $this->warn("⚠️  Slow database connection: {$connectionTime}ms");
            } else {
                $this->info("✅ Database connection: {$connectionTime}ms");
            }

            // Check for slow queries
            $this->checkSlowQueries();

        } catch (\Exception $e) {
            $this->error("❌ Database check failed: " . $e->getMessage());
        }
    }

    /**
     * Check cache performance
     */
    private function checkCachePerformance(): void
    {
        $this->line('🚀 Checking cache performance...');

        try {
            $stats = $this->cacheService->getStats();
            
            $this->info("Cache driver: " . $stats['driver']);
            
            if (isset($stats['hit_rate'])) {
                $hitRate = floatval(str_replace('%', '', $stats['hit_rate']));
                
                if ($hitRate < 80) {
                    $this->warn("⚠️  Low cache hit rate: {$stats['hit_rate']}");
                } else {
                    $this->info("✅ Cache hit rate: {$stats['hit_rate']}");
                }
            }

            if (isset($stats['memory_used'])) {
                $this->info("Cache memory usage: {$stats['memory_used']}");
            }

        } catch (\Exception $e) {
            $this->error("❌ Cache check failed: " . $e->getMessage());
        }
    }

    /**
     * Check storage performance
     */
    private function checkStoragePerformance(): void
    {
        $this->line('💾 Checking storage performance...');

        try {
            $testFile = 'performance_test_' . uniqid() . '.txt';
            $testData = str_repeat('test', 1000); // 4KB test data

            $start = microtime(true);
            Storage::put($testFile, $testData);
            $writeTime = (microtime(true) - $start) * 1000;

            $start = microtime(true);
            Storage::get($testFile);
            $readTime = (microtime(true) - $start) * 1000;

            Storage::delete($testFile);

            $this->info("✅ Storage write: {$writeTime}ms, read: {$readTime}ms");

            if ($writeTime > 100 || $readTime > 50) {
                $this->warn("⚠️  Storage performance may be slow");
            }

        } catch (\Exception $e) {
            $this->error("❌ Storage check failed: " . $e->getMessage());
        }
    }

    /**
     * Check memory usage
     */
    private function checkMemoryUsage(): void
    {
        $this->line('🧠 Checking memory usage...');

        $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
        $memoryPeak = memory_get_peak_usage(true) / 1024 / 1024; // MB
        $memoryLimit = ini_get('memory_limit');

        $this->info("Current memory: " . number_format($memoryUsage, 2) . "MB");
        $this->info("Peak memory: " . number_format($memoryPeak, 2) . "MB");
        $this->info("Memory limit: {$memoryLimit}");

        if ($memoryUsage > 128) {
            $this->warn("⚠️  High memory usage detected");
        }
    }

    /**
     * Check for slow queries
     */
    private function checkSlowQueries(): void
    {
        // Enable query logging temporarily
        DB::enableQueryLog();

        // Run some test queries
        try {
            \App\Models\Patient::count();
            \App\Models\User::count();
            
            $queries = DB::getQueryLog();
            
            foreach ($queries as $query) {
                $time = $query['time'] ?? 0;
                if ($time > 100) { // 100ms threshold
                    $this->warn("⚠️  Slow query detected: {$time}ms - " . substr($query['query'], 0, 50) . '...');
                }
            }
            
        } catch (\Exception $e) {
            $this->warn("Could not check slow queries: " . $e->getMessage());
        }

        DB::disableQueryLog();
    }

    /**
     * Get database statistics
     */
    private function getDatabaseStats(): array
    {
        try {
            return [
                'patients_count' => \App\Models\Patient::count(),
                'users_count' => \App\Models\User::count(),
                'consultations_count' => \App\Models\Consultation::count(),
                'connection_time' => $this->measureDatabaseConnection(),
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get cache statistics
     */
    private function getCacheStats(): array
    {
        return $this->cacheService->getStats();
    }

    /**
     * Get storage statistics
     */
    private function getStorageStats(): array
    {
        try {
            $disk = Storage::disk();
            return [
                'driver' => config('filesystems.default'),
                'available_space' => $this->getAvailableSpace(),
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get memory statistics
     */
    private function getMemoryStats(): array
    {
        return [
            'current_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_usage_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'limit' => ini_get('memory_limit'),
        ];
    }

    /**
     * Get application statistics
     */
    private function getApplicationStats(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug'),
        ];
    }

    /**
     * Measure database connection time
     */
    private function measureDatabaseConnection(): float
    {
        $start = microtime(true);
        DB::select('SELECT 1');
        return round((microtime(true) - $start) * 1000, 2);
    }

    /**
     * Get available storage space
     */
    private function getAvailableSpace(): string
    {
        try {
            $bytes = disk_free_space(storage_path());
            return $this->formatBytes($bytes);
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Display report summary
     */
    private function displayReportSummary(array $report): void
    {
        $this->info('📊 Performance Report Summary:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        if (isset($report['database']['connection_time'])) {
            $this->line("Database connection: {$report['database']['connection_time']}ms");
        }
        
        if (isset($report['cache']['hit_rate'])) {
            $this->line("Cache hit rate: {$report['cache']['hit_rate']}");
        }
        
        if (isset($report['memory']['current_usage_mb'])) {
            $this->line("Memory usage: {$report['memory']['current_usage_mb']}MB");
        }
        
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
