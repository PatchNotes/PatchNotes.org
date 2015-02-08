@extends('layouts/master')

@section('title', "Organizations on PatchNotes")

@section('content')


<div class="row">
    <div class="col-lg-9">
        <h2>Organizations</h2>
        <p>Companies and Teams working on the same projects.</p>
    </div>
    <div class="col-lg-3">
        @if(Sentry::check())

        <a href="/organizations/create" class="btn btn-primary btn-block">Create a Organization</a>

        @else
            <p>Sign in to create an organization.</p>
        @endif
    </div>
</div>

    <div class="row">
        <div class="col-lg-12">
            @include('organizations/partials/list', ['organizations' => $organizations])
        </div>
    </div>

@stop
