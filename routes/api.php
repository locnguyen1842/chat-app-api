<?php

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', 'Auth\UserController@store');
    Route::post('/login', 'Auth\UserController@login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('logout', 'Auth\UserController@logout');
        Route::get('profile', 'Auth\UserController@profile');
    });
});
