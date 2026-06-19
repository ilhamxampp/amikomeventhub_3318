<?php

/**
 * Konfigurasi Midtrans untuk Payment Gateway
 */
return [
    // Mode: 'production' atau 'sandbox'
    'mode' => env('MIDTRANS_MODE', 'sandbox'),

    // Sandbox Credentials
    'sandbox' => [
        'merchant_id' => env('MIDTRANS_SANDBOX_MERCHANT_ID', 'G141532908'),
        'client_key'  => env('MIDTRANS_SANDBOX_CLIENT_KEY', 'SB-Mid-client-1234567890abcdef'),
        'server_key'  => env('MIDTRANS_SANDBOX_SERVER_KEY', 'SB-Mid-server-1234567890abcdef'),
    ],

    // Production Credentials
    'production' => [
        'merchant_id' => env('MIDTRANS_PRODUCTION_MERCHANT_ID'),
        'client_key'  => env('MIDTRANS_PRODUCTION_CLIENT_KEY'),
        'server_key'  => env('MIDTRANS_PRODUCTION_SERVER_KEY'),
    ],

    'server_key' => env('MIDTRANS_SERVER_KEY', env('MIDTRANS_MODE', 'sandbox') === 'production'
        ? env('MIDTRANS_PRODUCTION_SERVER_KEY')
        : env('MIDTRANS_SANDBOX_SERVER_KEY')),

    'client_key' => env('MIDTRANS_CLIENT_KEY', env('MIDTRANS_MODE', 'sandbox') === 'production'
        ? env('MIDTRANS_PRODUCTION_CLIENT_KEY')
        : env('MIDTRANS_SANDBOX_CLIENT_KEY')),

    'merchant_id' => env('MIDTRANS_MODE', 'sandbox') === 'production'
        ? env('MIDTRANS_PRODUCTION_MERCHANT_ID')
        : env('MIDTRANS_SANDBOX_MERCHANT_ID'),
];
