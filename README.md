# Magic DB

[![Latest Version](https://img.shields.io/github/release/Flamentist/magicdb.svg?style=flat-square)](https://github.com/Flamentist/magicdb/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/flamento/magicdb.svg?style=flat-square)](https://packagist.org/packages/flamento/magicdb)

Magic DB is a database manager that you can easily integrate to your Laravel application.

- Easy access to your database via `/magicdb/login` route.
- Perform SQL and CRUD operations on your tables.
- Automatic Daily Backup of your database (.gzip file).
- Download a backup copy of your database.

## Installation

The recommended way to install Magic DB is via
[Composer](https://getcomposer.org/).

```bash
composer require flamento/magicdb
```

## Configuration

### Publish the configuration file

```bash
php artisan vendor:publish --provider="Flamento\MagicDB\MagicDBServiceProvider"
```

### Content of the configuration file

```php
return [
    'middleware' => ['web'],
    /* 2 request per 5 minutes for backup endpoint*/
    'backup_throtlle' => 'throttle:2,5,magicdb_backup',
    /* 2 request per minute for login/logout endpoint*/
    'auth_throttle' => 'throttle:2,1,magicdb_auth',

    /* If Magic DB should backup every day, > .gzip saved in storage/app/magicdb/backup  */
    'backup_daily' => true,

    /* Credential to access Magic DB via /magicdb/login page*/
    'MAGICDB_USERNAME' => env('MAGICDB_USERNAME', 'admin'),
    'MAGICDB_PASSWORD' => env('MAGICDB_PASSWORD', 'admin'),

    /* Your database settings */
    'DB_USERNAME' => env('DB_USERNAME', 'root'),
    'DB_PASSWORD' => env('DB_PASSWORD', ''),
    'DB_HOST' => env('DB_HOST', 'localhost'),
    'DB_DATABASE' => env('DB_DATABASE', ''),
];
```

## Setting up Cron Job

### For Linux Server

If you wish to have a daily backup of your database, you need to setup a cron job.

```bash
* * * * * php /path-to-your-project/artisan schedule:run 1>> /dev/null 2>&1

OR

* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### For Windows Server

Please use Task Scheduler available in Windows.

> To find out more about setting up a cron job, please visit [Laravel Task Scheduler](https://laravel.com/docs/5.8/scheduling#introduction) to setup a cron job.

## Supported Versions

Magic DB is supported on Laravel 7.0 and above as well as PHP 7.2 and above. This is as far as I can test, but it may work on older versions. However, this library is not meant to be used on older versions of Laravel and PHP except on the versions mentioned above.

## Security

If you discover a security vulnerability within this package, please send an
email to akosiyawin@gmail.com. All security vulnerabilities will be promptly
addressed. Please do not disclose security-related issues publicly until a fix
has been announced.

## License

Magic DB is open-sourced software licensed under the [MIT license](LICENSE.md).
