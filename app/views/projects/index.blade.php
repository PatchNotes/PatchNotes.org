@extends('layouts/master')

@section('content')

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
                        <div class="col-md-4"><b>{{ count($project->updates()) }}</b><br/><small>Subs</small></div>
                        <div class="col-md-4"><b>{{ count($project->updates()) }}</b><br/><small>Updates</small></div>
                        <div class="col-md-4"><b>{{ count($project->managers()) }}</b><br/><small>Managers</small></div>
                    </div>
                </div>
            </a>
        </div>

    @endforeach
</div>

@stop
