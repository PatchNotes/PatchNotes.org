@extends('layouts/master')

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

        <h2>Users</h2>

        <div class="row">
            @foreach($users as $user)
            <div class="col-xs-2 col-md-1">
                <a href="/users/{{{ $user->username }}}" class="thumbnail">
                    <img src="{{ $user->getGravatar() }}" alt="">
                </a>
            </div>
            @endforeach
        </div>

    @endif



@stop
