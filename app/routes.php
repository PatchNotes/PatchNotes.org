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
	Route::resource('projects', 'Projects\\ProjectController');

    Route::get('projects/{orgOrUser}/{name}', 'Projects\\ProjectController@show');
    Route::get('projects/{orgOrUser}/{name}/edit', 'Projects\\ProjectController@edit');
    Route::put('projects/{orgOrUser}/{name}', 'Projects\\ProjectController@update');
    Route::patch('projects/{orgOrUser}/{name}', 'Projects\\ProjectController@update');
    Route::delete('projects/{orgOrUser}/{name}', 'Projects\\ProjectController@destroy');

	Route::resource('projects/{groupOrUsername}/{name}/updates', 'Projects\\UpdateController');
	Route::resource('projects/{groupOrUsername}/{name}/subscription', 'Projects\\SubscriptionController');
	Route::controller('projects/{groupOrUsername}/{name}/share', 'Projects\\ShareController');
	Route::get('projects/{groupOrUsername}/{name}/updates.rss', 'Projects\\UpdateController@indexRSS');
});

