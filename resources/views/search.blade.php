@extends('layouts/master')

@section('title', 'Search Projects')

@section('content')


    @if($errors->count() > 0)

    <h2>Ooops! <small>There was a problem with your search query</small></h2>

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $message)
            <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>

    @else

        <h2>Projects</h2>
        @include('projects/partials/list')

        <h2>Users</h2>

        <div class="row">
            @foreach($users as $user)
            <div class="col-xs-2 col-md-1">
                <a href="/users/{{ $user->username }}" class="thumbnail">
                    <img src="{!! $user->gravatar !!}" alt="">
                </a>
            </div>
            @endforeach
        </div>

    @endif



@stop
