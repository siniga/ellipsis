<?php

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
//resert cache routes
// clear route cache
Route::get('/clear-route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has clear successfully !';
});

//clear config cache
Route::get('/clear-config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has clear successfully !';
});

// clear application cache
Route::get('/clear-app-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has clear successfully!';
});

// clear view cache
Route::get('/clear-view-cache', function () {
    Artisan::call('view:clear');
    return 'View cache has clear successfully!';
});

// header('Access-Control-Allow-Origin', '*');
// header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers', 'Content-Type, Authorization');


//public route
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

//verify phone
Route::get('verify-phone/{phone}', 'UserController@verifyPhone');

//protected route
Route::group(['middleware' => ['auth:sanctum']], function(){

    //authentication
    Route::post('user/update', 'AuthController@updateUserDetails');
    Route::post('logout', 'AuthController@logout');


    //roles
    Route::get('roles', 'RoleController@index');

    //users
    Route::get('users', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::post('user', 'UserController@store');
    Route::post('user/update', 'UserController@update');
    Route::delete('user/{uid}/role/{rid}', 'UserController@destroy');
    Route::get('user/{uid}/book/{bid}/favourite','UserController@isMarkedFavourite');
    Route::get('user/{uid}/book/{bid}/like','UserController@getUserLike');
    Route::get('user/{id}/favourites', 'UserController@getUserFavouriteBooks');


    //books
    Route::get('books', 'BookController@index');
    Route::get('book/{id}/show', 'BookController@show');
    Route::post('book', 'BookController@store');
    Route::post('book/update', 'BookController@update');
    Route::delete('book/{id}', 'BookController@destroy');

    //favourites
    Route::get('favourites', 'FavouriteController@index');
    Route::post('favourite', 'FavouriteController@store');
    Route::delete('favourite/user/{uid}/book/{bid}', 'FavouriteController@destroy');

    //likes
    Route::get('likes', 'LikeController@index');
    Route::post('like', 'LikeController@store');
    Route::delete('like/user/{uid}/book/{bid}', 'LikeController@destroy');

    //comments
    Route::get('comments', 'CommentController@index');
    Route::get('comments/book/{id}', 'CommentController@getBookComments');
    Route::post('comment', 'CommentController@store');
    Route::delete('comment/user/{uid}/book/{bid}', 'CommentController@destroy');
}); 

