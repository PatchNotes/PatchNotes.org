@extends('layouts/master')

@section('content')


<h2>{{{ $user->username }}}</h2>
<div class="row">
    <div class="col-md-3">
        <ul>
            <li>Joined On: {{ $user->created_at }}</li>
            <li>Last Login: {{ $user->last_login }}</li>
        </ul>
        <img src="" alt="">
    </div>
    <div class="col-md-8 col-md-offset-1">
        <h3>Projects</h3>
        <?php $projects = $user->projects; ?>
        @include('projects/partials/list')
    </div>
</div>

@stop
