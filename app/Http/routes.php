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

// Main homepage
Route::get('/', function () {
    return view('pages.index');
});

// First checkin
Route::get('first-checkin/', ['uses' => 'FirstCheckinController@index', 'as' => 'firstcheckin.index']);
