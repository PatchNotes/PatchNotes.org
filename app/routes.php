<?php

Route::get('/', 'HomeController@getIndex');
Route::get('/search', 'SearchController@getSearch');

/* Accounts & Users */
Route::group(array('prefix' => 'account'), function () {
	Route::controller('', 'Account\\AccountController');
	Route::controller('settings', 'Account\\SettingController');
});
Route::group(array('prefix' => 'users'), function () {
	Route::get('', 'UserController@getIndex');
	Route::get('users/{username}', 'UserController@getUser');
});
Route::group(array(), function () {
	Route::resource('organizations', 'OrganizationController');
});

/* Documentation */
Route::group(array(), function () {
	Route::controller('about', 'AboutController');
	Route::controller('help', 'HelpController');
});

/* Projects */
Route::group(array(), function () {
	Route::get('projects', 'Projects\\ProjectController@index');
	Route::get('projects/create', 'Projects\\ProjectController@create');
	Route::post('projects', 'Projects\\ProjectController@store');

	Route::get('projects/{participant}/{name}', 'Projects\\ProjectController@show');
	Route::get('projects/{participant}/{name}/edit', 'Projects\\ProjectController@edit');
	Route::put('projects/{participant}/{name}', 'Projects\\ProjectController@update');
	Route::patch('projects/{participant}/{name}', 'Projects\\ProjectController@update');
	Route::delete('projects/{participant}/{name}', 'Projects\\ProjectController@destroy');

	Route::resource('projects/{participant}/{name}/updates', 'Projects\\UpdateController');
	Route::resource('projects/{participant}/{name}/subscription', 'Projects\\SubscriptionController');
	Route::controller('projects/{participant}/{name}/share', 'Projects\\ShareController');
	Route::get('projects/{participant}/{name}/updates.rss', 'Projects\\UpdateController@indexRSS');
});

