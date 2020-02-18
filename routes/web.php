<?php

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

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/', 'MapController@index')->name('index');
Route::get('test', 'PostController@index');
// Route::get('test', 'TestController@test')->name('test');
// Route::post('test', 'PlaceApiController@test')->name('test');
Route::post('get_place_detail', 'PlaceApiController@getPlaceDetail')->name('get_place_detail');
Route::get('get_header_image', 'PlaceApiController@getHeaderImage')->name('get_header_image');



// Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::prefix('ratings')->group(function () {
    // フォーム表示用
    // Route::get('add', 'PostController@addForm');

    Route::get('get', 'PostController@getRatings')->name('get_ratings');
    // POSTデータを受け取る用
    Route::post('update', 'PostController@updateRatings');

    // Route::get('edit{id}', 'PostController@updateRatings');
});
