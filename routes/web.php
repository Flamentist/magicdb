<?php

use Flamento\MagicDB\Http\Controllers\MagicDBController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => config('magicdb.middleware', ['web']), "prefix" => 'magicdb'], function () {

    Route::get('/login', [MagicDBController::class, 'loginIndex'])->name('magicdb.loginIndex');
    Route::post('/login', [MagicDBController::class, 'login'])->middleware(config('magicdb.auth_throttle', 'throttle:2,1,magicdb_auth'))->name('magicdb.login');
    Route::get('/logout', [MagicDBController::class, 'logout'])->name('magicdb.logout');
    Route::get('/dashboard', [MagicDBController::class, 'index'])->name('magicdb.index');
    Route::get('/tables/{tableName}', [MagicDBController::class, 'showTable'])->name('magicdb.showTable');

    Route::post('/mysql/backup', [MagicDBController::class, 'mysqlBackup'])->middleware(config('magicdb.backup_throtlle', 'throttle:2,5,magicdb_backup'))->name('magicdb.mysqlBackup');
});
