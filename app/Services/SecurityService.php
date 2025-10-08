<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SecurityService
{
    /**
     * Rate limiting configurations
     */
    const RATE_LIMITS = [
        'login' => ['attempts' => 5, 'decay' => 900], // 5 attempts per 15 minutes
        'api' => ['attempts' => 100, 'decay' => 3600], // 100 requests per hour
        'password_reset' => ['attempts' => 3, 'decay' => 1800], // 3 attempts per 30 minutes
    ];

    /**
     * Check if IP is rate limited for specific action
     */
    public function isRateLimited(string $ip, string $action): bool
    {
        if (!isset(self::RATE_LIMITS[$action])) {
            return false;
        }

        $key = "rate_limit:{$action}:{$ip}";
        $attempts = Cache::get($key, 0);
        $limit = self::RATE_LIMITS[$action]['attempts'];

        return $attempts >= $limit;
    }

    /**
     * Increment rate limit counter
     */
    public function incrementRateLimit(string $ip, string $action): int
    {
        if (!isset(self::RATE_LIMITS[$action])) {
            return 0;
        }

        $key = "rate_limit:{$action}:{$ip}";
        $decay = self::RATE_LIMITS[$action]['decay'];
        
        $attempts = Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, $decay);

        return $attempts;
    }

    /**
     * Clear rate limit for IP and action
     */
    public function clearRateLimit(string $ip, string $action): void
    {
        $key = "rate_limit:{$action}:{$ip}";
        Cache::forget($key);
    }

    /**
     * Detect suspicious activity patterns
     */
    public function detectSuspiciousActivity(Request $request): array
    {
        $suspiciousIndicators = [];
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Check for SQL injection patterns
        if ($this->containsSqlInjectionPatterns($request)) {
            $suspiciousIndicators[] = 'sql_injection_attempt';
        }

        // Check for XSS patterns
        if ($this->containsXssPatterns($request)) {
            $suspiciousIndicators[] = 'xss_attempt';
        }

        // Check for unusual request frequency
        if ($this->hasUnusualRequestFrequency($ip)) {
            $suspiciousIndicators[] = 'high_request_frequency';
        }

        // Check for bot-like behavior
        if ($this->isBotLikeBehavior($userAgent, $request)) {
            $suspiciousIndicators[] = 'bot_like_behavior';
        }

        // Check for directory traversal attempts
        if ($this->containsDirectoryTraversalPatterns($request)) {
            $suspiciousIndicators[] = 'directory_traversal_attempt';
        }

        // Log suspicious activity
        if (!empty($suspiciousIndicators)) {
            $this->logSuspiciousActivity($request, $suspiciousIndicators);
        }

        return $suspiciousIndicators;
    }

    /**
     * Generate secure session token
     */
    public function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Validate password strength
     */
    public function validatePasswordStrength(string $password): array
    {
        $errors = [];
        $score = 0;

        // Length check
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        } else {
            $score += 1;
        }

        // Uppercase letter check
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        } else {
            $score += 1;
        }

        // Lowercase letter check
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        } else {
            $score += 1;
        }

        // Number check
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        } else {
            $score += 1;
        }

        // Special character check
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        } else {
            $score += 1;
        }

        // Common password check
        if ($this->isCommonPassword($password)) {
            $errors[] = 'Password is too common, please choose a more unique password';
            $score -= 2;
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors,
            'strength_score' => max(0, $score),
            'strength_level' => $this->getPasswordStrengthLevel($score)
        ];
    }

    /**
     * Encrypt sensitive data
     */
    public function encryptSensitiveData(string $data): string
    {
        $key = config('app.key');
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
        
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypt sensitive data
     */
    public function decryptSensitiveData(string $encryptedData): string
    {
        $key = config('app.key');
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        
        return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
    }

    /**
     * Generate audit trail entry
     */
    public function createAuditTrail(string $action, array $data = [], $user = null): void
    {
        $auditData = [
            'action' => $action,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => $data,
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('audit')->info('Audit Trail', $auditData);

        // Store in database for critical actions
        if ($this->isCriticalAction($action)) {
            \DB::table('audit_logs')->insert([
                'action' => $action,
                'user_id' => $auditData['user_id'],
                'ip_address' => $auditData['ip_address'],
                'user_agent' => $auditData['user_agent'],
                'data' => json_encode($data),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Check for SQL injection patterns
     */
    private function containsSqlInjectionPatterns(Request $request): bool
    {
        $patterns = [
            '/(\bUNION\b.*\bSELECT\b)/i',
            '/(\bSELECT\b.*\bFROM\b)/i',
            '/(\bINSERT\b.*\bINTO\b)/i',
            '/(\bUPDATE\b.*\bSET\b)/i',
            '/(\bDELETE\b.*\bFROM\b)/i',
            '/(\bDROP\b.*\bTABLE\b)/i',
            '/(\'|\")(\s*)(or|and)(\s*)(\'|\")(\s*)(=|!=|<>)(\s*)(\'|\")/i',
            '/(\bor\b|\band\b)(\s+)(\d+)(\s*)(=|!=|<>)(\s*)(\d+)/i'
        ];

        $input = json_encode($request->all());

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for XSS patterns
     */
    private function containsXssPatterns(Request $request): bool
    {
        $patterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<object/i',
            '/<embed/i',
            '/expression\s*\(/i'
        ];

        $input = json_encode($request->all());

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for unusual request frequency
     */
    private function hasUnusualRequestFrequency(string $ip): bool
    {
        $key = "request_frequency:{$ip}";
        $requests = Cache::get($key, []);
        $now = time();
        
        // Remove requests older than 1 minute
        $requests = array_filter($requests, function ($timestamp) use ($now) {
            return ($now - $timestamp) < 60;
        });

        // Add current request
        $requests[] = $now;
        Cache::put($key, $requests, 300); // Store for 5 minutes

        // Check if more than 30 requests in last minute
        return count($requests) > 30;
    }

    /**
     * Check for bot-like behavior
     */
    private function isBotLikeBehavior(string $userAgent, Request $request): bool
    {
        $botPatterns = [
            '/bot/i',
            '/crawler/i',
            '/spider/i',
            '/scraper/i',
            '/curl/i',
            '/wget/i'
        ];

        foreach ($botPatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        // Check for missing common headers
        $requiredHeaders = ['accept', 'accept-language', 'accept-encoding'];
        foreach ($requiredHeaders as $header) {
            if (!$request->hasHeader($header)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for directory traversal patterns
     */
    private function containsDirectoryTraversalPatterns(Request $request): bool
    {
        $patterns = [
            '/\.\.\//',
            '/\.\.\\\\/',
            '/%2e%2e%2f/',
            '/%2e%2e%5c/',
            '/\.\.\%2f/',
            '/\.\.\%5c/'
        ];

        $input = $request->getRequestUri() . json_encode($request->all());

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Log suspicious activity
     */
    private function logSuspiciousActivity(Request $request, array $indicators): void
    {
        Log::warning('Suspicious activity detected', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'indicators' => $indicators,
            'input' => $request->all(),
            'timestamp' => now()->toISOString()
        ]);

        // Increment security incident counter
        $key = "security_incidents:" . $request->ip();
        $incidents = Cache::get($key, 0) + 1;
        Cache::put($key, $incidents, 3600); // Store for 1 hour

        // Auto-block IP if too many incidents
        if ($incidents >= 10) {
            $this->blockIpAddress($request->ip(), 'Automated block due to multiple security incidents');
        }
    }

    /**
     * Block IP address
     */
    private function blockIpAddress(string $ip, string $reason): void
    {
        Cache::put("blocked_ip:{$ip}", [
            'reason' => $reason,
            'blocked_at' => now()->toISOString(),
            'expires_at' => now()->addHours(24)->toISOString()
        ], 86400); // Block for 24 hours

        Log::critical('IP address blocked', [
            'ip' => $ip,
            'reason' => $reason,
            'blocked_until' => now()->addHours(24)->toISOString()
        ]);
    }

    /**
     * Check if password is commonly used
     */
    private function isCommonPassword(string $password): bool
    {
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey',
            'dragon', 'master', 'shadow', 'superman', 'michael'
        ];

        return in_array(strtolower($password), $commonPasswords);
    }

    /**
     * Get password strength level
     */
    private function getPasswordStrengthLevel(int $score): string
    {
        return match (true) {
            $score >= 5 => 'Very Strong',
            $score >= 4 => 'Strong',
            $score >= 3 => 'Medium',
            $score >= 2 => 'Weak',
            default => 'Very Weak'
        };
    }

    /**
     * Check if action is critical for audit logging
     */
    private function isCriticalAction(string $action): bool
    {
        $criticalActions = [
            'user_login',
            'user_logout',
            'password_change',
            'user_created',
            'user_deleted',
            'patient_created',
            'patient_deleted',
            'consultation_created',
            'facture_created',
            'system_backup',
            'configuration_changed'
        ];

        return in_array($action, $criticalActions);
    }
}
