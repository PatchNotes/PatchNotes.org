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


<div class="row projects">
    @foreach($projects as $project)

        <div class="col-md-3">
            <a href="/projects/{{ $project->slug }}" class="thumbnail project">
                <div class="caption">
                    <h2>{{{ $project->name }}}</h2>
                    <p>{{{ $project->description }}}</p>
                </div>
                <div class="modal-footer" style="text-align: left">
                    <div class="row project-info">
                        <div class="col-md-6 text-center">
                            <b>{{ count($project->updates()) }}</b><br/><small>Subscribers</small>
                        </div>
                        <div class="col-md-6 text-center">
                            <b>{{ count($project->updates()) }}</b><br/><small>Updates</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    @endforeach
</div>

@stop
