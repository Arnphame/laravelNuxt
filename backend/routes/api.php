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

1 - admin
0 - user
*/

Route::post('/register', 'AuthController@register');
Route::post('/login ', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

Route::group(['prefix' => 'games'], function() {
    Route::post('/', 'GameController@store')->middleware('auth:api')->middleware('auth.role:1');
    Route::get('/mygames', 'GameController@showMyGames')->middleware('auth:api')->middleware('auth.role:0,1');
    Route::get('/', 'GameController@index');
    Route::get('/{game}', 'GameController@show');
    Route::patch('/{game}', 'GameController@update')->middleware('auth:api')->middleware('auth.role:1');
    Route::delete('/{game}', 'GameController@destroy')->middleware('auth:api')->middleware('auth.role:1');
    Route::post('/join/{game}', 'GameController@join')->middleware('auth:api');
    Route::post('/leave/{game}', 'GameController@leave')->middleware('auth:api');
    Route::patch('/complete/{game}', 'GameController@completeManually')->middleware('auth:api')->middleware('auth.role:1');



    Route::group(['prefix' => '/{game}/match'], function () {
       Route::get('/', 'MatchController@index')->middleware('auth:api');
       Route::get('/{match}', 'MatchController@show')->middleware('auth:api');
       Route::patch('/{match}', 'MatchController@update')->middleware('auth:api')->middleware('auth.role:1');
       Route::delete('/{match}', 'MatchController@destroy')->middleware('auth:api')->middleware('auth.role:1');
       Route::post('/', 'MatchController@store')->middleware('auth:api')->middleware('auth.role:1');
       Route::post('/{match}/user/{user}', 'MatchController@storePlayer')->middleware('auth:api');
       //Route::post('/{match}/{user}', 'MatchController@storePlayer')->middleware('auth:api');
    });
});
