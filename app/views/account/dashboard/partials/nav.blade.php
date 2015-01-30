<div class="well text-center">
        <img src="{{ $user->gravatar }}" alt="">
        <h3>{{ $user->username }}</h3>
</div>

<div class="list-group">
    <a href="{{ URL::action('Account\\DashboardController@getSubscriptions') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getSubscriptions' ? 'active ': 'sdfsa' }}">
        Subscriptions
    </a>
    <a href="{{ URL::action('Account\\DashboardController@getPreferences') }}"
       class="list-group-item {{ Route::currentRouteAction() == 'Account\\DashboardController@getPreferences' ? 'active ': 'sdfsa' }}">
        Preferences
    </a>
</div>