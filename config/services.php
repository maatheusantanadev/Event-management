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

    'paggue' => [
    'client_key' => env('PAGGUE_CLIENT_KEY'),
    'client_secret' => env('PAGGUE_CLIENT_SECRET'),
    'access_token' => env('PAGGUE_ACCESS_TOKEN'),
    'company_id' => env('PAGGUE_COMPANY_ID'),
    'webhook_secret' => env('PAGGUE_SIGNING_SECRET'),
    'base_url' => env('PAGGUE_BASE_URL', 'https://ms.paggue.io'),
    ],

   

    'mailersend' => [
        'key' => env('MAILERSEND_API_KEY'),
    ],


    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
