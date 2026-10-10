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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'supabase' => [
        'project_ref' => env('SUPABASE_PROJECT_REF', 'oyzvcqaytavbfwdrgili'),
        'url' => env('SUPABASE_URL', 'https://oyzvcqaytavbfwdrgili.supabase.co'),
        'key' => env('SUPABASE_KEY', ''),
        'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY', ''),
    ],

    'onepass' => [
        'client_id' => env('ONEPASS_CLIENT_ID', 'cp3_client_GEO6TVWojyxq9i7bM2LS'),
        'client_secret' => env('ONEPASS_CLIENT_SECRET', 'cp3_sec_UbzWwxTbaKO5jmqmZ2O5HGxpnWRMjV2I82iQ'),
        'issuer_url' => env('ONEPASS_ISSUER_URL', 'https://onepass-gdbe.onrender.com'),
        'redirect_uri' => env('ONEPASS_REDIRECT_URI', 'http://127.0.0.1:8000/oauth/callback'),
    ],

];
