<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'service_key' => [
            'type' => env('FIREBASE_SERVICE_TYPE'),
            'project_id' => env('FIREBASE_SERVICE_PROJECT_ID'),
            'private_key_id' => env('FIREBASE_SERVICE_PRIVATE_KEY_ID'),
            'private_key' => str_replace('\n', "\n", env('FIREBASE_SERVICE_PRIVATE_KEY')),
            'client_email' => env('FIREBASE_SERVICE_CLIENT_EMAIL'),
            'client_id' => env('FIREBASE_SERVICE_CLIENT_ID'),
            'auth_uri' => env('FIREBASE_SERVICE_AUTH_URI'),
            'token_uri' => env('FIREBASE_SERVICE_TOKEN_URI'),
            'auth_provider_x509_cert_url' => env('FIREBASE_SERVICE_AUTH_PROVIDER_X509_CERT_URL'),
            'client_x509_cert_url' => env('FIREBASE_SERVICE_CLIENT_X509_CERT_URL'),
        ],
    ],

];
