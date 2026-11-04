<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        // Admin dashboard users
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // Front-end readers (sign up / sign in)
        'maanuser' => [
            'driver' => 'session',
            'provider' => 'maanusers',
        ],
        // Mobile API (Laravel Passport)
        'api' => [
            'driver' => 'passport',
            'provider' => 'api',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
        'maanusers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Maanuser::class,
        ],
        'api' => [
            'driver' => 'eloquent',
            'model' => App\Models\Maanuser::class,
        ],
    ],

    'passwords' => [
        'maanusers' => [
            'provider' => 'maanusers',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_resets'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_resets'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'api' => [
            'provider' => 'api',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_resets'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
