<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemPosterController;
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

Route::get('item-poster/{hashid}', [ItemPosterController::class, 'index'])
    ->name('item-poster');

Route::get('dashboard', fn () => view('dashboard'))
    ->middleware('auth')
    ->name('dashboard');

Route::get('/', fn () => view('home'))
    ->name('home');

Route::group([
    'prefix' => 'spreadsheets',
    'as' => 'spreadsheets.',
    'middleware' => 'auth',
], function () {
    Route::get('scrape', fn () => view('spreadsheets.scrape'))
        ->name('scrape');

    Route::get('upload', fn () => view('spreadsheets.upload'))
        ->name('upload');
});

Route::group([
    'prefix' => 'movies',
    'as' => 'movies.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('movies.index'))
        ->name('index');

    Route::get('create', fn () => view('movies.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('movies.edit', ['hashid' => $hashid]))
        ->name('edit');
});

Route::group([
    'prefix' => 'tv-shows',
    'as' => 'tv-shows.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('tv-show.index'))
        ->name('index');

    Route::get('create', fn () => view('tv-show.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('tv-show.edit', ['hashid' => $hashid]))
        ->name('edit');
});

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
