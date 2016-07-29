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
Route::get('/profile', 'UserController@edit');
Route::patch('/profile', 'UserController@update');

//Route::resource('venues', 'VenueController');

Route::get('test', function(){
    return view('test');
});

Route::get('/venues', 'VenueController@index');
Route::post('/venues', 'VenueController@store');
Route::get('/venues/create', 'VenueController@create');
Route::get('/venues/{venues}', 'VenueController@show');
Route::patch('/venues/{venues}', 'VenueController@update');
Route::get('/venues/{venues}/edit', 'VenueController@edit');
