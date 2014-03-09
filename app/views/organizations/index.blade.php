@extends('layouts/master')

@section('content')


<div class="row">
    <div class="col-lg-9">

        We'll explain organizations here.
    </div>
    <div class="col-lg-3">
        @if(Sentry::check())

        <a href="/organizations/create" class="btn btn-primary btn-block">Create a Organization</a>
        <ul class="list-group">
            @foreach($orgs as $org)
            <li class="list-group-item">{{{ $org->name }}}</li>
            @endforeach
        </ul>


        @else
            <p>Sign in to create an organization.</p>
        @endif
    </div>
</div>

@stop
