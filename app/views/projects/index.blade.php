@extends('layouts/master')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <h2>Projects</h2>
    </div>
    <div class="col-lg-6">
        <div class="pull-right">
            <br>
            <a href="/projects/create" class="btn btn-primary">Create New Project</a>
        </div>

    </div>
</div>


@foreach($projects as $project)

    <h4>{{ HTML::linkAction('ProjectController@show', $project->name, array($project->slug)) }} - {{ count($project->updates) }} updates</h4>

@endforeach


@stop
