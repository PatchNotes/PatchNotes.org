<?php

Route::get('/', 'HomeController@getIndex');
Route::get('/search', 'SearchController@getSearch');

/* Accounts & Users */
Route::group(array('prefix' => 'account'), function () {
	Route::controller('', 'Account\\AccountController');
	Route::controller('dashboard', 'Account\\DashboardController');
});
Route::group(array('prefix' => 'users'), function () {
	Route::get('', 'UserController@getIndex');
	Route::get('users/{username}', 'UserController@getUser');
});

/* Documentation */
Route::group(array(), function () {
	Route::controller('about', 'AboutController');
	Route::controller('help', 'HelpController');
});

/* Projects */
Route::group(array(), function () {
	Route::resource('projects', 'Projects\\ProjectController');
	Route::resource('projects/{name}/updates', 'Projects\\UpdateController');
	Route::resource('projects/{name}/subscription', 'Projects\\SubscriptionController');
	Route::controller('projects/{name}/share', 'Projects\\ShareController');
	Route::get('projects/{name}/updates.rss', 'Projects\\UpdateController@indexRSS');
});

