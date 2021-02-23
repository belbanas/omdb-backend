<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchlistController;
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

//Route::resource('registration', UserController::class);
Route::post('registration', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = auth()->user();
    return response()->json([
        'message' => 'ok',
        'user' => $user
    ], 200);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/watchlist', [WatchListController::class, 'addMovie']);
    Route::get('/watchlist', [WatchListController::class, 'showMovies']);
    Route::post('/delete', [WatchListController::class, 'removeMovie']);
    Route::post('/rating', [WatchListController::class, 'sendRating']);
    Route::post('/review', [WatchListController::class, 'sendReview']);
});



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
