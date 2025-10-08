<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use ZipArchive;

class BackupSystemCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'backup:system 
                            {--type=full : Type of backup (full, database, files)}
                            {--compress : Compress backup files}
                            {--encrypt : Encrypt backup files}
                            {--remote : Upload to remote storage}';

    /**
     * The console command description.
     */
    protected $description = 'Create comprehensive system backup including database and files';

    protected $backupPath;
    protected $timestamp;

    public function __construct()
    {
        parent::__construct();
        $this->timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $this->backupPath = storage_path('backups');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting system backup...');
        
        $type = $this->option('type');
        $compress = $this->option('compress');
        $encrypt = $this->option('encrypt');
        $remote = $this->option('remote');

        try {
            // Ensure backup directory exists
            if (!is_dir($this->backupPath)) {
                mkdir($this->backupPath, 0755, true);
            }

            $backupFiles = [];

            switch ($type) {
                case 'database':
                    $backupFiles[] = $this->backupDatabase();
                    break;
                case 'files':
                    $backupFiles[] = $this->backupFiles();
                    break;
                case 'full':
                default:
                    $backupFiles[] = $this->backupDatabase();
                    $backupFiles[] = $this->backupFiles();
                    $backupFiles[] = $this->backupConfiguration();
                    break;
            }

            // Remove null values
            $backupFiles = array_filter($backupFiles);

            if (empty($backupFiles)) {
                $this->error('❌ No backup files created');
                return 1;
            }

            // Compress if requested
            if ($compress) {
                $compressedFile = $this->compressBackup($backupFiles);
                $backupFiles = [$compressedFile];
            }

            // Encrypt if requested
            if ($encrypt) {
                $backupFiles = array_map([$this, 'encryptFile'], $backupFiles);
            }

            // Upload to remote storage if requested
            if ($remote) {
                foreach ($backupFiles as $file) {
                    $this->uploadToRemote($file);
                }
            }

            // Clean old backups
            $this->cleanOldBackups();

            // Generate backup report
            $this->generateBackupReport($backupFiles, $type);

            $this->info('✅ System backup completed successfully!');
            $this->displayBackupSummary($backupFiles);

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Backup failed: ' . $e->getMessage());
            Log::error('System backup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Backup database
     */
    protected function backupDatabase(): string
    {
        $this->line('📊 Backing up database...');

        $connection = config('database.default');
        $config = config("database.connections.{$connection}");
        
        $filename = "database_backup_{$this->timestamp}.sql";
        $filepath = $this->backupPath . '/' . $filename;

        switch ($config['driver']) {
            case 'mysql':
                $this->backupMysqlDatabase($config, $filepath);
                break;
            case 'pgsql':
                $this->backupPostgresDatabase($config, $filepath);
                break;
            case 'sqlite':
                $this->backupSqliteDatabase($config, $filepath);
                break;
            default:
                throw new \Exception("Unsupported database driver: {$config['driver']}");
        }

        $this->info("✅ Database backup created: {$filename}");
        return $filepath;
    }

    /**
     * Backup MySQL database
     */
    protected function backupMysqlDatabase(array $config, string $filepath): void
    {
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s > %s',
            escapeshellarg($config['host']),
            escapeshellarg($config['port']),
            escapeshellarg($config['username']),
            escapeshellarg($config['password']),
            escapeshellarg($config['database']),
            escapeshellarg($filepath)
        );

        $result = null;
        $output = [];
        exec($command, $output, $result);

        if ($result !== 0) {
            throw new \Exception('MySQL backup failed: ' . implode("\n", $output));
        }
    }

    /**
     * Backup application files
     */
    protected function backupFiles(): string
    {
        $this->line('📁 Backing up application files...');

        $filename = "files_backup_{$this->timestamp}.tar.gz";
        $filepath = $this->backupPath . '/' . $filename;

        // Directories to backup
        $directories = [
            'storage/app',
            'public/images',
            'public/uploads',
            'resources/views',
        ];

        // Files to backup
        $files = [
            '.env',
            'composer.json',
            'composer.lock',
            'package.json',
            'package-lock.json',
        ];

        $this->createTarArchive($filepath, $directories, $files);

        $this->info("✅ Files backup created: {$filename}");
        return $filepath;
    }

    /**
     * Backup configuration
     */
    protected function backupConfiguration(): string
    {
        $this->line('⚙️ Backing up configuration...');

        $filename = "config_backup_{$this->timestamp}.json";
        $filepath = $this->backupPath . '/' . $filename;

        $config = [
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'debug' => config('app.debug'),
                'url' => config('app.url'),
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ],
            'database' => [
                'default' => config('database.default'),
                'connections' => array_map(function ($connection) {
                    // Remove sensitive data
                    unset($connection['password']);
                    return $connection;
                }, config('database.connections')),
            ],
            'cache' => config('cache'),
            'session' => config('session'),
            'mail' => array_merge(config('mail'), [
                'password' => '***HIDDEN***'
            ]),
            'services' => config('services'),
            'backup_metadata' => [
                'created_at' => now()->toISOString(),
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'server_info' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            ]
        ];

        file_put_contents($filepath, json_encode($config, JSON_PRETTY_PRINT));

        $this->info("✅ Configuration backup created: {$filename}");
        return $filepath;
    }

    /**
     * Compress backup files
     */
    protected function compressBackup(array $files): string
    {
        $this->line('🗜️ Compressing backup files...');

        $filename = "compressed_backup_{$this->timestamp}.zip";
        $filepath = $this->backupPath . '/' . $filename;

        $zip = new ZipArchive();
        if ($zip->open($filepath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception("Cannot create zip file: {$filepath}");
        }

        foreach ($files as $file) {
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            }
        }

        $zip->close();

        // Remove original files after compression
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $this->info("✅ Backup compressed: {$filename}");
        return $filepath;
    }

    /**
     * Encrypt backup file
     */
    protected function encryptFile(string $filepath): string
    {
        $this->line('🔐 Encrypting backup file...');

        $encryptedFilepath = $filepath . '.enc';
        $key = config('app.key');
        
        if (empty($key)) {
            throw new \Exception('Application key not set for encryption');
        }

        $data = file_get_contents($filepath);
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
        
        file_put_contents($encryptedFilepath, base64_encode($iv . $encrypted));
        
        // Remove original file
        unlink($filepath);

        $this->info("✅ Backup encrypted: " . basename($encryptedFilepath));
        return $encryptedFilepath;
    }

    /**
     * Upload backup to remote storage
     */
    protected function uploadToRemote(string $filepath): void
    {
        $this->line('☁️ Uploading to remote storage...');

        $filename = basename($filepath);
        $remotePath = 'backups/' . date('Y/m/') . $filename;

        try {
            // Upload to configured remote disk (S3, FTP, etc.)
            $disk = Storage::disk(config('backup.remote_disk', 's3'));
            $disk->putFileAs('backups/' . date('Y/m'), $filepath, $filename);

            $this->info("✅ Uploaded to remote storage: {$remotePath}");

        } catch (\Exception $e) {
            $this->warn("⚠️ Remote upload failed: " . $e->getMessage());
        }
    }

    /**
     * Clean old backups
     */
    protected function cleanOldBackups(): void
    {
        $this->line('🧹 Cleaning old backups...');

        $retentionDays = config('backup.retention_days', 30);
        $cutoffDate = Carbon::now()->subDays($retentionDays);

        $files = glob($this->backupPath . '/*');
        $deletedCount = 0;

        foreach ($files as $file) {
            if (is_file($file)) {
                $fileDate = Carbon::createFromTimestamp(filemtime($file));
                
                if ($fileDate->lt($cutoffDate)) {
                    unlink($file);
                    $deletedCount++;
                }
            }
        }

        if ($deletedCount > 0) {
            $this->info("✅ Cleaned {$deletedCount} old backup files");
        }
    }

    /**
     * Generate backup report
     */
    protected function generateBackupReport(array $backupFiles, string $type): void
    {
        $report = [
            'backup_id' => uniqid('backup_'),
            'timestamp' => $this->timestamp,
            'type' => $type,
            'files' => [],
            'total_size' => 0,
            'status' => 'completed',
            'duration' => null,
            'system_info' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'memory_usage' => memory_get_peak_usage(true),
            ]
        ];

        foreach ($backupFiles as $file) {
            if (file_exists($file)) {
                $size = filesize($file);
                $report['files'][] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $size,
                    'size_human' => $this->formatBytes($size),
                ];
                $report['total_size'] += $size;
            }
        }

        $report['total_size_human'] = $this->formatBytes($report['total_size']);

        $reportFile = $this->backupPath . "/backup_report_{$this->timestamp}.json";
        file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));

        Log::info('Backup completed', $report);
    }

    /**
     * Display backup summary
     */
    protected function displayBackupSummary(array $backupFiles): void
    {
        $this->line('');
        $this->line('📋 Backup Summary:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $totalSize = 0;
        foreach ($backupFiles as $file) {
            if (file_exists($file)) {
                $size = filesize($file);
                $totalSize += $size;
                $this->line(sprintf(
                    '📄 %s (%s)',
                    basename($file),
                    $this->formatBytes($size)
                ));
            }
        }

        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line("📊 Total size: {$this->formatBytes($totalSize)}");
        $this->line("📅 Timestamp: {$this->timestamp}");
        $this->line("📁 Location: {$this->backupPath}");
    }

    /**
     * Create tar archive
     */
    protected function createTarArchive(string $filepath, array $directories, array $files): void
    {
        $command = "tar -czf " . escapeshellarg($filepath);

        foreach ($directories as $dir) {
            if (is_dir(base_path($dir))) {
                $command .= " -C " . escapeshellarg(base_path()) . " " . escapeshellarg($dir);
            }
        }

        foreach ($files as $file) {
            if (file_exists(base_path($file))) {
                $command .= " -C " . escapeshellarg(base_path()) . " " . escapeshellarg($file);
            }
        }

        $result = null;
        $output = [];
        exec($command, $output, $result);

        if ($result !== 0) {
            throw new \Exception('File backup failed: ' . implode("\n", $output));
        }
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Backup PostgreSQL database
     */
    protected function backupPostgresDatabase(array $config, string $filepath): void
    {
        $command = sprintf(
            'PGPASSWORD=%s pg_dump --host=%s --port=%s --username=%s --format=custom --no-owner --no-acl %s > %s',
            escapeshellarg($config['password']),
            escapeshellarg($config['host']),
            escapeshellarg($config['port']),
            escapeshellarg($config['username']),
            escapeshellarg($config['database']),
            escapeshellarg($filepath)
        );

        $result = null;
        $output = [];
        exec($command, $output, $result);

        if ($result !== 0) {
            throw new \Exception('PostgreSQL backup failed: ' . implode("\n", $output));
        }
    }

    /**
     * Backup SQLite database
     */
    protected function backupSqliteDatabase(array $config, string $filepath): void
    {
        $dbPath = $config['database'];
        
        if (!file_exists($dbPath)) {
            throw new \Exception("SQLite database file not found: {$dbPath}");
        }

        if (!copy($dbPath, $filepath)) {
            throw new \Exception("Failed to copy SQLite database");
        }
    }
}
