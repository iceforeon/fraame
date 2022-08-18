<?php

use App\Http\Controllers\PosterController;
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

Route::get('create/watchlist', fn () => view('watchlist'))
    ->name('watchlist');

Route::get('poster/{hashid}', [PosterController::class, 'index'])
    ->name('poster');

Route::get('dashboard', fn () => view('dashboard'))
    ->middleware('auth')
    ->name('dashboard');

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
    'prefix' => 'animes',
    'as' => 'animes.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('animes.index'))
        ->name('index');

    Route::get('create', fn () => view('animes.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('animes.edit', ['hashid' => $hashid]))
        ->name('edit');
});

Route::group([
    'prefix' => 'watchlists',
    'as' => 'watchlists.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('watchlists.index'))
        ->name('index');

    Route::get('watchlists', fn () => view('watchlists.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('watchlists.edit', ['hashid' => $hashid]))
        ->name('edit');
});

require __DIR__.'/auth.php';

Route::get('privacy', fn () => view('privacy'))
    ->name('privacy');

Route::get('terms', fn () => view('terms'))
    ->name('terms');

Route::get('settings', fn () => view('settings'))
    ->name('settings')
    ->middleware('auth');

Route::get('/', fn () => view('home'))
    ->name('home');
