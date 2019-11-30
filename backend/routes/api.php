<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'AuthController@register');
Route::post('/login ', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

Route::group(['prefix' => 'games'], function() {
    Route::post('/', 'GameController@store')->middleware('auth:api');
    Route::get('/', 'GameController@index');
    Route::get('/{game}', 'GameController@show');
    Route::patch('/{game}', 'GameController@update')->middleware('auth:api');
    Route::delete('/{game}', 'GameController@destroy')->middleware('auth:api');
});
