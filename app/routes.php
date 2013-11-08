<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function () {
    return View::make('home');
});

Route::get('/search', function() {
    $query = Input::get('query');
    echo $query;
});

Route::controller('account', 'AccountController');

Route::controller('about', 'AboutController');
Route::resource('projects', 'ProjectController');
