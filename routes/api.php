<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Board\BoardController;
use App\Http\Controllers\Api\Task\TaskController;
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
//register route
Route::post('register', [RegisterController::class, 'register']);

//login route
Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    //logout route api
    Route::post('logout', [LoginController::class, 'logout']);

    //board api route
    Route::group(['prefix' => 'board'], function () {
        Route::get('get', [BoardController::class, 'getData']);
        Route::get('show/{id}', [BoardController::class, 'show']);
        Route::post('create', [BoardController::class, 'create']);
        Route::delete('delete/{id}', [BoardController::class, 'delete']);
        Route::put('edit/{id}', [BoardController::class, 'edit']);
    });
    //task api route
    Route::group(['prefix' => 'task'], function () {
        Route::get('get', [Taskontroller::class, 'getData']);
        Route::get('show/{id}', [TaskController::class, 'show']);
        Route::post('create', [TaskController::class, 'create']);
        Route::delete('delete/{id}', [TaskController::class, 'delete']);
        Route::put('edit/{id}', [TaskController::class, 'edit']);
    });
});
