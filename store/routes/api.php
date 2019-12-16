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

Route::prefix('auth')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    
    Route::group(['middleware' => 'jwt-middleware'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
    });

});

Route::group(['middleware' => 'jwt-middleware'], function(){
    Route::get('users', 'UserController@index')->middleware('admin');
    Route::get('users/{id}', 'UserController@show')->middleware('admin-self');
});

Route::group(['prefix'=> 'products', 'middleware' => 'jwt-middleware'], function(){
    Route::get( '/', 'ProductController@index')->middleware('admin');
    Route::post('/', 'ProductController@create')->middleware('admin');
    Route::put('/{product}', 'ProductController@update')->middleware('admin');
    Route::delete( '/{product}', 'ProductController@delete')->middleware('admin');
    Route::post("/{product}/image", 'ProductController@setImage')->middleware('admin');
    Route::post("/load", 'ProductController@loadCVS')->middleware('admin');    

});

Route::group(['prefix'=> 'products'], function(){
    Route::get( '/random', 'ProductController@random');
    Route::get( '/{product}', 'ProductController@show');
});

Route::group(['prefix' => 'categories'], function(){
    Route::get('/', 'CategoryController@index');
});
