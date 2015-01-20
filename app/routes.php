<?php

Route::get('/', 'HomeController@getIndex');
Route::get('/search', 'SearchController@getSearch');

/* Accounts & Users */
Route::group(['prefix' => 'account', 'namespace' => 'Account'], function () {
    Route::controller('', 'AccountController');
    Route::get('login', 'AccountController@getLogin');
    Route::post('login', 'AccountController@postLogin');
    
    Route::get('register', 'AccountController@getRegister');
    Route::post('register', 'AccountController@postRegister');
    
    // thanks/validate/forgot/reset/resetting/logout
    
    Route::group(['before' => 'auth'], function() {
        Route::get('dashboard', ['as' => 'account.dashboard', 'uses' => 'DashboardController@getIndex']);
        Route::get('dashboard/profile', ['as' => 'account.dashboard.profile', 'uses' => 'DashboardController@getProfile']);
        Route::get('dashboard/subscriptions', ['as' => 'account.dashboard.subscriptions', 'uses' => 'DashboardController@getSubscriptions']);
        Route::put('dashboard/subscriptions', ['as' => 'account.dashboard.subscriptions.update', 'uses' => 'DashboardController@postSubscriptions']);
    });
});

/* Social Authing */
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
Route::group(['prefix' => 'organizations'], function () {
    Route::get('', 'OrganizationController@index');
    Route::get('{name}', 'OrganizationController@show');
    
    Route::group(['before' => 'auth'], function() {
        Route::post('{name}', 'OrganizationController@store');
        Route::get('{name}/edit', 'OrganizationController@edit');
        Route::put('{name}', 'OrganizationController@update');
        Route::patch('{name}', 'OrganizationController@update');
        Route::delete('{name}', 'OrganizationController@destroy');
    });
});

/* Documentation */
Route::group([], function () {
    Route::get('about', 'AboutController@getIndex');
    Route::get('about/tos', 'AboutController@getTos');
    Route::get('about/privacy', 'AboutController@getPrivacy');
    
    Route::get('help/welcome', 'HelpController@getWelcome');
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

