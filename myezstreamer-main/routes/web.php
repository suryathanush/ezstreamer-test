<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\CloudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    ])->group(function () 
    {

        Route::get('/overview', [StreamController::class, 'overview'])->name('overview');
        Route::post('/streams/restart', [StreamController::class, 'restart'])->name('streams_restart');
        Route::post('/streams/standbytest', [StreamController::class, 'standbytest'])->name('streams_standbytest');
        Route::get('/monitor', [StreamController::class, 'monitor'])->name('monitor');

        //CRUD
        Route::get('/streams', [StreamController::class, 'edit'])->name('streams_edit');
        Route::post('/streams/update/{id}', [StreamController::class, 'update'])->name('streams_update');
        Route::get('/streams/new', [StreamController::class, 'new'])->name('streams_new');
        Route::post('/streams/delete/{id}', [StreamController::class, 'destroy'])->name('streams_delete');
        Route::get('/streams/remove_image/{id}', [StreamController::class, 'remove_image'])->name('remove_image');

        Route::get('/cloudtoken', [CloudController::class, 'viewtoken'])->name('view_token');
        Route::post('/cloudtoken', [CloudController::class, 'settoken'])->name('set_token');

    });

