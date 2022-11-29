<?php

return [

    'middleware' => ['web'],
    'backup_throtlle' => 'throttle:2,5,magicdb_backup',
    'auth_throttle' => 'throttle:2,1,magicdb_auth',

    /* If Magic DB should backup every day, > .gzip saved in storage/app/magicdb/backup  */
    'backup_daily' => true,

    /* Credential to access Magic DB via /magicdb/login page*/
    'MAGICDB_USERNAME' => env('MAGICDB_USERNAME', 'admin'),
    'MAGICDB_PASSWORD' => env('MAGICDB_PASSWORD', 'admin'),


    'DB_USERNAME' => env('DB_USERNAME', 'root'),
    'DB_PASSWORD' => env('DB_PASSWORD', ''),
    'DB_HOST' => env('DB_HOST', 'localhost'),
    'DB_DATABASE' => env('DB_DATABASE', ''),
];
