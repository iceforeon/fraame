<?php

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

Route::get('item-poster/{item}', [ItemPosterController::class, 'index'])
    ->name('item-poster');

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

Route::group([
    'prefix' => 'items',
    'as' => 'items.',
    'middleware' => 'auth',
], function () {
    Route::get('/', fn () => view('items.index'))
        ->name('index');

    Route::get('create', fn () => view('items.create'))
        ->name('create');

    Route::get('{hashid}/edit', fn ($hashid) => view('items.edit', ['hashid' => $hashid]))
        ->name('edit');
});

require __DIR__.'/auth.php';
