<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'line_message' => [
        'channel_id' => env('LINE_CHANNEL_ID', '1653393251'),
        'channel_secret' => env('LINE_CHANNEL_SECRET', 'fa6dbec86a7311c9aa3316f7ec591050'),
        'channel_access_token' => env('LINE_CHANNEL_ACCESS_TOKEN', 'I8Ai//+yeDtpGOLabOfkHz36csOdhwJ5Ye4U/96WmwXC8/C6L+Wf3zY6kCpNrhqVU0Zg4N6VcnYtijt9/T1qBh8KXjkmGedxTshVxSiVAv9lGzzpfZ9Texx2KdHZJeBKruZ1LVWOe0y4XZVa8E6LCwdB04t89/1O/w1cDnyilFU=')
    ]

];
