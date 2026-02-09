<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayHero Basic Authentication
    |--------------------------------------------------------------------------
    |
    | Base64 encoded string for Basic authentication
    | Format: base64_encode(username:password)
    |
    */
    'basic_auth' => env('PAYHERO_BASIC_AUTH', 'c1dhSjh5NzZJdDV4TnpteWRUcXU6eWN3elNHaGpuS3V5UWJISm9PbzJyTGxpNW42d2d6dHpjYWgyemx5ag=='),
    
    /*
    |--------------------------------------------------------------------------
    | PayHero Channel ID
    |--------------------------------------------------------------------------
    |
    | Your PayHero channel ID (e.g., 133)
    |
    */
    'channel_id' => env('PAYHERO_CHANNEL_ID', 133),
    
    /*
    |--------------------------------------------------------------------------
    | Callback URL
    |--------------------------------------------------------------------------
    |
    | URL where PayHero will send payment callbacks
    |
    */
    'callback_url' => env('PAYHERO_CALLBACK_URL', 'https://yourdomain.com/api/payhero/callback'),
    
    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    |
    | Secret for verifying webhook signatures (if provided by PayHero)
    |
    */
    'webhook_secret' => env('PAYHERO_WEBHOOK_SECRET', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Application environment (local, staging, production)
    |
    */
    'env' => env('PAYHERO_ENV', 'production'),
    
    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable detailed logging for debugging
    |
    */
    'logging' => env('PAYHERO_LOGGING', true),
];