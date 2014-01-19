@extends('layouts/master')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <h2>Projects &amp; Services</h2>
        <p>Here you'll find a list of various projects and services that have been added to PatchNotes.</p>
    </div>    
    <div class="col-lg-6">
        <div class="pull-right">
            <a href="/projects/create" class="btn btn-primary">Add a Project</a>
        </div>
    </div>
</div>


@include('projects/partials/list')

<div class="text-center">
{{ $projects->links(); }}
</div>

@stop
