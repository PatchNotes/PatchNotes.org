@extends('layouts/master')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="well text-center">
            <img src="{{ $user->gravatar }}" alt="">
            <h3>{{ $user->username }}</h3>

            @if($user->id == Sentry::getUser()->id)
                <a href="{{ URL::action('Account\DashboardController@getIndex') }}">Your Dashboard</a>
            @endif
        </div>

        <ul>
            <li>Joined On: {{ $user->created_at }}</li>
            <li>Last Login: {{ $user->last_login }}</li>
        </ul>
    </div>
    <div class="col-md-9">
        <h3>Projects</h3>
        @include('projects/partials/list', ['projects' => $user->projects])
    </div>
</div>

@stop
