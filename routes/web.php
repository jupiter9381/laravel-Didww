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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/didLogin', 'Auth\LoginController@didLogin');
Route::get('/available_dids', 'DidsController@available');
Route::post('/did_reservation', 'DidsController@did_reservation');
Route::post('/available_dids/search', 'DidsController@search');
Route::get("/did_reservations/{id}", 'DidsController@view_reservation');

Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/getRegions', 'DidsController@getRegions');
Route::post('/getCitiesByCountry', 'DidsController@getCitiesByCountry');
Route::post('/getCitiesByRegion', 'DidsController@getCitiesByRegion');