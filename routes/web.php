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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'MapController@index');
Route::get('test', 'PostController@index');
// Route::get('test', 'TestController@test')->name('test');
// Route::post('test', 'PlaceApiController@test')->name('test');
Route::post('get_place_detail', 'PlaceApiController@getPlaceDetail')->name('get_place_detail');
Route::get('get_header_image', 'PlaceApiController@getHeaderImage')->name('get_header_image');