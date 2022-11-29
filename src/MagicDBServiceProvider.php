<?php

namespace Flamento\MagicDB;

use Flamento\MagicDB\Console\Commands\MagicDBBackup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class MagicDBServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'magicdb');

        $this->publishes([
            __DIR__ . '/../config/magicdb.php' => config_path('magicdb.php'),
        ], 'magicdb-config');


        /* Call Scheduler */
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            if (config('magicdb.backup_daily')) {
                $schedule->command('magicdb:backup')->daily();
            }
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/magicdb.php',
            'magicdb'
        );

        $this->commands([
            MagicDBBackup::class,
        ]);
    }
}
