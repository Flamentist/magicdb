<?php

return [

    /* Middlewares */
    'middleware' => ['web'],
    'backup_throtlle' => 'throttle:2,5',
    /* Auth Middleware */
    'auth_throttle' => 'throttle:2,1',

    'MAGICDB_USERNAME' => env('MAGICDB_USERNAME', 'admin'),
    'MAGICDB_PASSWORD' => env('MAGICDB_PASSWORD', 'admin'),

    'DB_USERNAME' => env('DB_USERNAME', 'root'),
    'DB_PASSWORD' => env('DB_PASSWORD', ''),
    'DB_HOST' => env('DB_HOST', 'localhost'),
    'DB_DATABASE' => env('DB_DATABASE', ''),


];
