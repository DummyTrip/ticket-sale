<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');
Route::get('/profile', 'UserController@update');
Route::post('/profile', 'UserController@store');

Route::get('/venues', 'VenueController@index');
Route::get('/venues/create', 'VenueController@create');
Route::get('/venues/{id}', 'VenueController@show');
Route::get('/venues/{id}/update', 'VenueController@update');
Route::post('/venues', 'VenueController@store');
