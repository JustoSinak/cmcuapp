<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request with enhanced security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy
        $csp = $this->buildContentSecurityPolicy();
        $response->headers->set('Content-Security-Policy', $csp);

        // Security Headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', $this->buildPermissionsPolicy());
        
        // HSTS (HTTP Strict Transport Security)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Remove server information
        $response->headers->remove('Server');
        $response->headers->remove('X-Powered-By');

        // Cache control for sensitive pages
        if ($this->isSensitivePage($request)) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }

    /**
     * Build Content Security Policy
     */
    private function buildContentSecurityPolicy(): string
    {
        $policies = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: https: blob:",
            "connect-src 'self' https://api.pusher.com wss://ws.pusherapp.com",
            "media-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "upgrade-insecure-requests"
        ];

        return implode('; ', $policies);
    }

    /**
     * Build Permissions Policy
     */
    private function buildPermissionsPolicy(): string
    {
        $policies = [
            'camera=self',
            'microphone=self',
            'geolocation=self',
            'payment=self',
            'usb=(),',
            'magnetometer=()',
            'accelerometer=()',
            'gyroscope=()',
            'fullscreen=self'
        ];

        return implode(', ', $policies);
    }

    /**
     * Check if current page contains sensitive information
     */
    private function isSensitivePage(Request $request): bool
    {
        $sensitiveRoutes = [
            'admin/*',
            'patients/*',
            'factures/*',
            'consultations/*',
            'users/*'
        ];

        foreach ($sensitiveRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }
}
