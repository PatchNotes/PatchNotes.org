<?php

Route::get('/', 'HomeController@getIndex');
Route::get('/search', 'SearchController@getSearch');

/* Accounts & Users */
Route::group(['prefix' => 'account'], function () {
    Route::controller('dashboard', 'Account\\DashboardController');

    Route::controller('', 'Account\\AccountController');
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('validation-required', 'Account\\AuthController@getValidationRequired');
    Route::get('oauth-error', 'Account\\AuthController@getOauthError');
    Route::get('account-connected', 'Account\\AuthController@getAccountConnected');
    Route::get('validate-account/{key}', 'Account\\AuthController@getValidateAccount');
    Route::get('{provider}', 'Account\\AuthController@getOAuthStart');
    Route::get('{provider}/callback', 'Account\\AuthController@getOAuthCallback');
});

/* Users */
Route::group(['prefix' => 'users'], function () {
    Route::get('', 'UserController@getIndex');
    Route::get('{username}', 'UserController@getUser');
});

/* Organizations */
Route::group([], function () {
    Route::resource('organizations', 'OrganizationController');
});

/* Documentation */
Route::group([], function () {
    Route::controller('about', 'AboutController');
    Route::controller('help', 'HelpController');
});

/* Projects */
Route::group(['namespace' => 'Projects'], function () {
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{participant}/{name}', 'ProjectController@show');

    Route::get('projects/{participant}/{name}/updates', 'UpdateController@index');
    Route::get('projects/{participant}/{name}/updates.rss', 'UpdateController@indexRSS');
    Route::get('projects/{participant}/{name}/updates/{update}', 'UpdateController@show');

    Route::get('projects/{participant}/{name}/share/twitter', 'ShareController@getTwitter');
    Route::get('projects/{participant}/{name}/share/facebook', 'ShareController@getFacebook');
    Route::get('projects/{participant}/{name}/share/google', 'ShareController@getGoogle');

    /* Authenticated Routes */
    Route::group(['before' => 'auth'], function() {
        Route::get('projects/create', 'ProjectController@create');
        Route::post('projects', 'ProjectController@store');

        Route::post('projects/{participant}/{name}', 'ProjectController@store');
        Route::get('projects/{participant}/{name}/edit', 'ProjectController@edit');
        Route::put('projects/{participant}/{name}', 'ProjectController@update');
        Route::patch('projects/{participant}/{name}', 'ProjectController@update');
        Route::delete('projects/{participant}/{name}', 'ProjectController@destroy');

        Route::post('projects/{participant}/{name}/updates', 'UpdateController@store');
        Route::get('projects/{participant}/{name}/updates/{update}/edit', 'UpdateController@edit');
        Route::put('projects/{participant}/{name}/updates/{update}', 'UpdateController@update');
        Route::patch('projects/{participant}/{name}/updates/{update}', 'UpdateController@update');
        Route::delete('projects/{participant}/{name}/updates/{update}', 'UpdateController@destroy');

        Route::get('projects/{participant}/{name}/subscription', 'SubscriptionController@index');
        Route::post('projects/{participant}/{name}/subscription', 'SubscriptionController@store');
        Route::get('projects/{participant}/{name}/subscription/edit', 'SubscriptionController@edit');
        Route::put('projects/{participant}/{name}/subscription', 'SubscriptionController@update');
        Route::patch('projects/{participant}/{name}/subscription', 'SubscriptionController@update');
        Route::delete('projects/{participant}/{name}/subscription', 'SubscriptionController@destroy');
    });
});

