<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', fn () => view('welcome'));

Route::get('dashboard', fn () => view('dashboard'))
    ->middleware('auth')
    ->name('dashboard');

Route::group([
    'prefix' => 'posts',
    'as' => 'posts.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('posts.index'))
        ->name('index');

    Route::get('create', fn () => view('posts.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('posts.edit', ['hashid' => $hashid]))
        ->name('edit');
});

require __DIR__.'/auth.php';
