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
    $rules = array('query' => 'required|alpha_num');
    $validator = Validator::make(Input::all(), $rules);
    if($validator->fails()) {
        return View::make('search', array('errors' => $validator->errors()));
    }

    $projects = Project::where('name', 'LIKE', '%' . Input::get('query') . '%')->get();
    $users = User::where('username', 'LIKE', '%' . Input::get('query') . '%')->get();

    return View::make('search', compact('projects','users'));
});

Route::controller('account', 'AccountController');

Route::get('users', function() {
    App::abort(404);
});
Route::get('users/{username}', function($username) {
    $user = User::where('username', $username)->first();
    if(!$user) {
        App::abort(404);
    }

    return View::make('users/profile', compact('user'));
});

Route::controller('about', 'AboutController');
Route::controller('help', 'HelpController');

Route::resource('projects', 'Projects\\ProjectController');
Route::resource('projects/{name}/updates', 'Projects\\UpdateController');
Route::get('projects/{name}/updates.rss', function($project) {
    $project = Project::where('slug', $project)->first();

    $feed = Rss::feed('2.0', 'UTF-8');
    $feed->channel(array(
        'title' => $project->name,
        'description' => $project->description,
        'link' => action('Projects\\ProjectController@show', $project->slug)
    ));

    foreach($project->updates()->get() as $update) {
        $feed->item(array(
            'title' => $update->title,
            'description' => $update->body,
            'link' => action('Projects\\UpdateController@show', array($project->slug, $update->slug))
        ));
    }

    return Response::make($feed, 200, array('Content-Type' => 'text/xml'));

});
