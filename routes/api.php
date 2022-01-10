<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{movie}/show', [MovieController::class, 'show']);
    Route::post('/movies/create', [MovieController::class, 'store']);
    Route::put('/movies/{movie}/update', [MovieController::class, 'update']);
    Route::delete('/movies/{movie}/destroy', [MovieController::class, 'destroy']);

    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{review}/show', [ReviewController::class, 'show']);
    Route::post('/movies/{movie}/reviews/create', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}/update', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}/destroy', [ReviewController::class, 'destroy']);
});
