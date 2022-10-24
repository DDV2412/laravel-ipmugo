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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIEN_ID'),
        'client_secret' => env('GOOGLE_CLIEN_SECRET'),
        'redirect' => env('GOOGLE_CLIEN_REDIRECT'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIEN_ID'),
        'client_secret' => env('GITHUB_CLIEN_SECRET'),
        'redirect' => env('GITHUB_CLIEN_REDIRECT'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIEN_ID'),
        'client_secret' => env('FACEBOOK_CLIEN_SECRET'),
        'redirect' => env('FACEBOOK_CLIEN_REDIRECT'),
    ],

];
