<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CDNService
{
    protected $cdnUrl;
    protected $enabled;
    protected $zones;

    public function __construct()
    {
        $this->cdnUrl = config('services.cdn.url');
        $this->enabled = config('services.cdn.enabled', false);
        $this->zones = config('services.cdn.zones', []);
    }

    /**
     * Get optimized asset URL with CDN support
     */
    public function asset(string $path, array $options = []): string
    {
        if (!$this->enabled || empty($this->cdnUrl)) {
            return asset($path);
        }

        // Add version parameter for cache busting
        $version = $this->getAssetVersion($path);
        $queryParams = ['v' => $version];

        // Add optimization parameters
        if (isset($options['width'])) {
            $queryParams['w'] = $options['width'];
        }
        if (isset($options['height'])) {
            $queryParams['h'] = $options['height'];
        }
        if (isset($options['quality'])) {
            $queryParams['q'] = $options['quality'];
        }
        if (isset($options['format'])) {
            $queryParams['f'] = $options['format'];
        }

        $queryString = http_build_query($queryParams);
        $cdnPath = $this->getCDNPath($path);
        
        return $this->cdnUrl . '/' . ltrim($cdnPath, '/') . '?' . $queryString;
    }

    /**
     * Get optimized image URL with automatic WebP conversion
     */
    public function image(string $path, array $options = []): string
    {
        // Auto-detect WebP support
        if ($this->supportsWebP() && !isset($options['format'])) {
            $options['format'] = 'webp';
        }

        // Default quality for images
        if (!isset($options['quality'])) {
            $options['quality'] = 85;
        }

        return $this->asset($path, $options);
    }

    /**
     * Preload critical assets
     */
    public function preloadCriticalAssets(): array
    {
        $criticalAssets = [
            'css' => [
                '/css/app.css',
                '/css/bootstrap.min.css',
            ],
            'js' => [
                '/js/app.js',
                '/js/bootstrap.min.js',
            ],
            'fonts' => [
                '/fonts/fontawesome-webfont.woff2',
            ],
            'images' => [
                '/images/logo.png',
                '/images/icons/icon-192x192.png',
            ]
        ];

        $preloadLinks = [];

        foreach ($criticalAssets as $type => $assets) {
            foreach ($assets as $asset) {
                $preloadLinks[] = $this->generatePreloadLink($asset, $type);
            }
        }

        return $preloadLinks;
    }

    /**
     * Purge CDN cache for specific assets
     */
    public function purgeCache(array $paths): bool
    {
        if (!$this->enabled) {
            return true;
        }

        try {
            // Implementation depends on CDN provider (CloudFlare, AWS CloudFront, etc.)
            $this->purgeCDNCache($paths);
            
            Log::info('CDN cache purged successfully', ['paths' => $paths]);
            return true;

        } catch (\Exception $e) {
            Log::error('Failed to purge CDN cache', [
                'paths' => $paths,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Generate resource hints for performance
     */
    public function generateResourceHints(): array
    {
        $hints = [];

        // DNS prefetch for CDN domain
        if ($this->enabled && $this->cdnUrl) {
            $domain = parse_url($this->cdnUrl, PHP_URL_HOST);
            $hints[] = "<link rel=\"dns-prefetch\" href=\"//{$domain}\">";
            $hints[] = "<link rel=\"preconnect\" href=\"{$this->cdnUrl}\" crossorigin>";
        }

        // Prefetch critical resources
        $criticalResources = [
            '/api/dashboard/stats',
            '/api/patients/recent',
        ];

        foreach ($criticalResources as $resource) {
            $hints[] = "<link rel=\"prefetch\" href=\"{$resource}\">";
        }

        return $hints;
    }

    /**
     * Optimize and upload asset to CDN
     */
    public function uploadAsset(string $localPath, string $remotePath = null): bool
    {
        if (!$this->enabled) {
            return true;
        }

        try {
            $remotePath = $remotePath ?: $localPath;
            $content = Storage::get($localPath);
            
            // Optimize content based on file type
            $optimizedContent = $this->optimizeAssetContent($content, $localPath);
            
            // Upload to CDN storage
            $this->uploadToCDN($remotePath, $optimizedContent);
            
            Log::info('Asset uploaded to CDN', [
                'local_path' => $localPath,
                'remote_path' => $remotePath
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to upload asset to CDN', [
                'local_path' => $localPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get asset version for cache busting
     */
    protected function getAssetVersion(string $path): string
    {
        return Cache::remember("asset_version_{$path}", 3600, function () use ($path) {
            $fullPath = public_path($path);
            
            if (file_exists($fullPath)) {
                return substr(md5_file($fullPath), 0, 8);
            }
            
            return substr(md5($path), 0, 8);
        });
    }

    /**
     * Get CDN path with zone optimization
     */
    protected function getCDNPath(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        // Route to appropriate CDN zone based on file type
        foreach ($this->zones as $zone => $extensions) {
            if (in_array($extension, $extensions)) {
                return $zone . '/' . ltrim($path, '/');
            }
        }
        
        return ltrim($path, '/');
    }

    /**
     * Check if browser supports WebP
     */
    protected function supportsWebP(): bool
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        return str_contains($accept, 'image/webp');
    }

    /**
     * Generate preload link
     */
    protected function generatePreloadLink(string $asset, string $type): string
    {
        $url = $this->asset($asset);
        
        $as = match ($type) {
            'css' => 'style',
            'js' => 'script',
            'fonts' => 'font',
            'images' => 'image',
            default => 'fetch'
        };

        $crossorigin = in_array($type, ['fonts', 'images']) ? ' crossorigin' : '';
        
        return "<link rel=\"preload\" href=\"{$url}\" as=\"{$as}\"{$crossorigin}>";
    }

    /**
     * Optimize asset content
     */
    protected function optimizeAssetContent(string $content, string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        switch ($extension) {
            case 'css':
                return $this->minifyCSS($content);
            case 'js':
                return $this->minifyJS($content);
            case 'html':
                return $this->minifyHTML($content);
            default:
                return $content;
        }
    }

    /**
     * Minify CSS content
     */
    protected function minifyCSS(string $css): string
    {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        
        // Remove whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
        
        // Remove extra spaces
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Remove spaces around specific characters
        $css = str_replace([' {', '{ ', ' }', '} ', '; ', ' ;', ', ', ' ,'], ['{', '{', '}', '}', ';', ';', ',', ','], $css);
        
        return trim($css);
    }

    /**
     * Minify JavaScript content
     */
    protected function minifyJS(string $js): string
    {
        // Basic JS minification (for production, use a proper minifier)
        // Remove single-line comments
        $js = preg_replace('/\/\/.*$/m', '', $js);
        
        // Remove multi-line comments
        $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
        
        // Remove extra whitespace
        $js = preg_replace('/\s+/', ' ', $js);
        
        return trim($js);
    }

    /**
     * Minify HTML content
     */
    protected function minifyHTML(string $html): string
    {
        // Remove HTML comments (except IE conditionals)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);
        
        // Remove extra whitespace between tags
        $html = preg_replace('/>\s+</', '><', $html);
        
        // Remove extra whitespace
        $html = preg_replace('/\s+/', ' ', $html);
        
        return trim($html);
    }

    /**
     * Upload content to CDN (implementation depends on provider)
     */
    protected function uploadToCDN(string $path, string $content): void
    {
        // This would be implemented based on your CDN provider
        // Examples: AWS S3, CloudFlare, Azure CDN, etc.
        
        // For AWS S3:
        // Storage::disk('s3')->put($path, $content);
        
        // For CloudFlare:
        // $this->cloudflareAPI->uploadFile($path, $content);
        
        Log::info('CDN upload simulated', ['path' => $path, 'size' => strlen($content)]);
    }

    /**
     * Purge CDN cache (implementation depends on provider)
     */
    protected function purgeCDNCache(array $paths): void
    {
        // This would be implemented based on your CDN provider
        
        // For CloudFlare:
        // $this->cloudflareAPI->purgeCache($paths);
        
        // For AWS CloudFront:
        // $this->cloudFrontAPI->createInvalidation($paths);
        
        Log::info('CDN cache purge simulated', ['paths' => $paths]);
    }
}
