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

Route::get('posts', 'PostController@index');
Route::get('posts/{post}', 'PostController@show');

// only delete create and update post require authorization in our API
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('posts', 'PostController@store');
    Route::put('posts/{post}', 'PostController@update')->middleware('can:update,post');
    Route::delete('posts/{post}', 'PostController@delete')->middleware('can:delete,post');

    ////// gates test routes
    Route::get('gates/seePost/{post}', 'GatesController@seePost');
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');


