<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains performance-related configuration options for the
    | CMCU hospital management application.
    |
    */

    'cache' => [
        'dashboard_ttl' => env('CACHE_DASHBOARD_TTL', 300), // 5 minutes
        'patient_search_ttl' => env('CACHE_PATIENT_SEARCH_TTL', 600), // 10 minutes
        'page_cache_ttl' => env('CACHE_PAGE_TTL', 900), // 15 minutes
        'stats_ttl' => env('CACHE_STATS_TTL', 3600), // 1 hour
    ],

    'database' => [
        'slow_query_threshold' => env('DB_SLOW_QUERY_THRESHOLD', 1000), // milliseconds
        'connection_timeout' => env('DB_CONNECTION_TIMEOUT', 30),
        'max_connections' => env('DB_MAX_CONNECTIONS', 100),
    ],

    'pagination' => [
        'default_per_page' => env('PAGINATION_DEFAULT', 50),
        'max_per_page' => env('PAGINATION_MAX', 200),
    ],

    'assets' => [
        'enable_compression' => env('ASSETS_COMPRESSION', true),
        'enable_minification' => env('ASSETS_MINIFICATION', true),
        'cdn_url' => env('CDN_URL', null),
    ],

    'monitoring' => [
        'log_slow_requests' => env('LOG_SLOW_REQUESTS', true),
        'slow_request_threshold' => env('SLOW_REQUEST_THRESHOLD', 1000), // milliseconds
        'enable_query_logging' => env('ENABLE_QUERY_LOGGING', false),
    ],

    'optimization' => [
        'enable_opcache' => env('ENABLE_OPCACHE', true),
        'enable_route_caching' => env('ENABLE_ROUTE_CACHING', true),
        'enable_config_caching' => env('ENABLE_CONFIG_CACHING', true),
        'enable_view_caching' => env('ENABLE_VIEW_CACHING', true),
    ],

];
