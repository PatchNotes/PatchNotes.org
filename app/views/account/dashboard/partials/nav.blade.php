<div class="well text-center">
    <img src="{{ $user->gravatar }}" alt="">

    <h3>{{ $user->username }}</h3>
    <p><a href="{{ URL::action('UserController@getUser', [$user->slug]) }}">Your Public Profile</a></p>
</div>

<div class="list-group">
    <a href="{{ URL::action('Account\\DashboardController@getIndex') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getIndex' ? 'active ': '' }}">
        Dashboard
    </a>
    <a href="{{ URL::action('Account\\DashboardController@getSubscriptions') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getSubscriptions' ? 'active ': '' }}">
        Subscriptions
    </a>
    <a href="{{ URL::action('Account\\DashboardController@getPendingUpdates') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getPendingUpdates' ? 'active ': '' }}">
        Pending Updates
    </a>
    <a href="{{ URL::action('Account\\DashboardController@getPreferences') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getPreferences' ? 'active ': '' }}">
        Preferences
    </a>
</div>