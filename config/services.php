<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    // CDN Configuration
    'cdn' => [
        'enabled' => env('CDN_ENABLED', false),
        'url' => env('CDN_URL'),
        'zones' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
            'assets' => ['css', 'js', 'woff', 'woff2', 'ttf'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        ],
    ],

    // Elasticsearch Configuration
    'elasticsearch' => [
        'host' => env('ELASTICSEARCH_HOST', 'localhost:9200'),
        'username' => env('ELASTICSEARCH_USERNAME'),
        'password' => env('ELASTICSEARCH_PASSWORD'),
        'index_prefix' => env('ELASTICSEARCH_INDEX_PREFIX', 'cmcu_'),
    ],

    // WebSocket/Pusher Configuration
    'pusher' => [
        'app_id' => env('PUSHER_APP_ID'),
        'app_key' => env('PUSHER_APP_KEY'),
        'app_secret' => env('PUSHER_APP_SECRET'),
        'app_cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
        'encrypted' => true,
    ],

    // Backup Configuration
    'backup' => [
        'remote_disk' => env('BACKUP_REMOTE_DISK', 's3'),
        'retention_days' => env('BACKUP_RETENTION_DAYS', 30),
        'compress' => env('BACKUP_COMPRESS', true),
        'encrypt' => env('BACKUP_ENCRYPT', false),
    ],

];
