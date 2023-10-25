<?php

declare(strict_types=1);

return [
    'username' => env('VALLET_USERNAME'),
    'password' => env('VALLET_PASSWORD'),
    'shopcode' => env('VALLET_SHOPCODE'),
    'hash'     => env('VALLET_HASH'),

    'callbackUrl' => [
        'ok'   => env('VALLET_CALLBACK_OK_URL'),
        'fail' => env('VALLET_CALLBACK_FAIL_URL'),
    ],
];
