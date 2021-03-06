<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
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
Route::middleware('auth')->group(function () {
    Route::get('/users/{user:name}/movies/', [MovieController::class, 'index'])->name('movies');
    Route::get('/users/{user:name}/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('/movies/create/{user?}', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/store', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/users/{user:name}/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/users/{user:name}/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/users/{user:name}/movies/{movie}/delete', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::delete('/users/{user:name}/movies/{movie}/forceDelete', [MovieController::class, 'forceDelete'])->name('movies.forceDelete');
    Route::put('/users/{user:name}/movies/{movie}/restore', [MovieController::class, 'restore'])->name('movies.restore');
    Route::bind('movie', function ($id) {
        return \App\Models\Movie::withTrashed()->find($id);
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/users/{user:name}/movies/{movie}/review/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/feed/show', [HomeController::class, 'showFeed'])->name('feed.show');
    Route::get('/clients/show', [HomeController::class, 'showClients'])->name('clients.show');
    Route::post('/{user:name}/befriend', [HomeController::class, 'befriendUser'])->name('user.befriend');
    Route::post('{user:name}/unfriend', [HomeController::class, 'unfriendUser'])->name('user.unfriend');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
