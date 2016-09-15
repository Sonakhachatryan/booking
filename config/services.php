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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '579865905547251',
        'client_secret' => 'e8e8ed8f9a78d7c7982b55b832e55966',
        'redirect' => 'http://booking.app/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '67443677180-e2n21u6es3uvg2icrq5t34j24ld5idav.apps.googleusercontent.com',
        'client_secret' => 'x0xsr-peX3gRCAR39gqWEmR3',
        'redirect' => 'http://booking.app/auth/google/callback',
    ],

];
