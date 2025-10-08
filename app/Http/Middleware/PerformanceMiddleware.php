<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PerformanceMiddleware
{
    /**
     * Handle an incoming request with performance optimizations.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        // Enable response caching for GET requests
        if ($request->isMethod('GET') && !$request->user()) {
            $cacheKey = 'page_cache_' . md5($request->fullUrl());
            
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }
        
        $response = $next($request);
        
        // Cache GET responses for anonymous users
        if ($request->isMethod('GET') && !$request->user() && $response->getStatusCode() === 200) {
            $cacheKey = 'page_cache_' . md5($request->fullUrl());
            Cache::put($cacheKey, $response, now()->addMinutes(15));
        }
        
        // Log slow requests
        $executionTime = (microtime(true) - $startTime) * 1000;
        if ($executionTime > 1000) { // Log requests slower than 1 second
            Log::warning('Slow request detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'execution_time' => $executionTime . 'ms',
                'memory_usage' => memory_get_peak_usage(true) / 1024 / 1024 . 'MB'
            ]);
        }
        
        // Add performance headers
        $response->headers->set('X-Response-Time', $executionTime . 'ms');
        $response->headers->set('X-Memory-Usage', memory_get_peak_usage(true) / 1024 / 1024 . 'MB');
        
        return $response;
    }
}
