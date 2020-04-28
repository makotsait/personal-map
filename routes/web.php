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

Route::get('/', 'MapController@index')->middleware('sp.redirect')->middleware('auth')->name('index');
Route::get('sp', 'MapController@indexSp')->middleware('auth')->name('index.sp');
Route::get('test', 'PostController@index');
Route::get('get_place_type_options', 'PostController@getPlaceTypeOptions')->name('get.place.type.options');
// Route::get('test', 'TestController@test')->name('test');
// Route::post('get_place_detail', 'PlaceApiController@getPlaceDetail')->name('get_place_detail');
Route::get('fetch_place_details', 'PostController@fetchPlaceDetails')->name('fetch.place.details');
Route::get('get_header_image', 'PlaceApiController@getHeaderImage')->name('get_header_image');
Route::get('fetch-all-places-locations', 'PostController@fetchAllPlacesLocations')->name('fetch.all.places.locations');

// Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


Route::prefix('ratings')->group(function () {
    // フォーム表示用
    // Route::get('add', 'PostController@addForm');

    Route::get('get', 'PostController@fetchRatings')->name('get.ratings');
    // POSTデータを受け取る用
    Route::post('update', 'PostController@updateRatings');

    Route::post('delete', 'PostController@deleteRatings');

    // Route::get('edit{id}', 'PostController@updateRatings');
});
