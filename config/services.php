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

    'tmdb' => [
        'token' => env('TMDB_TOKEN'),
        'api_url' => env('TMDB_API_URL'),
        'poster_url' => env('TMDB_POSTER_URL'),
        'no_img_url' => env('TMDB_NO_IMAGE_URL'),
    ],

    'hashid' => [
        'salt' => 'fraame-hashid',
        'length' => 12,
        'alphabet' => 'abcdefghijklmnopqrstuvwxyz1234567890',
    ],

    'facebook' => [
        'page_id' => env('FACEBOOK_PAGE_ID'),
        'app_id' => env('FACEBOOK_APP_ID'),
        'app_secret' => env('FACEBOOK_APP_SECRET'),
        'graph_version' => env('FACEBOOK_GRAPH_VERSION', 'v11.0'),
        'default_graph_version' => env('FACEBOOK_GRAPH_VERSION', 'v11.0'),
        'beta_mode' => env('FACEBOOK_ENABLE_BETA', false),
        'default_access_token' => env('FACEBOOK_DEFAULT_ACCESS_TOKEN'),
    ],

];
