@extends('layouts/master')

@section('content')

<div class="row">

    <div class="col-lg-8">
        <h2><a href="{{ $project->url }}" target="_blank">{{{ $project->name }}}</a></h2>
        <p>{{ $project->description }}</p>

        <div>
            {{ $parser->transformMarkdown($project->content) }}
        </div>
    </div>
    <div class="col-lg-4">
        @if(Sentry::check())
            @if(Sentry::getUser()->id === $project->user_id)
            <h3>New Project Update</h3>

        @if($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif


        {{ Form::open(array('action' => 'UpdateController@store', 'class' => 'form-horizontal', 'role' => 'form')) }}
            <input type="hidden" name="project_id" value="{{ $project->id }}"/>
            <div class="form-group">
                <label for="updateTitle" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="title" id="updateTitle" placeholder="My Awesome Update">
                </div>
            </div>
            <div class="form-group">
                <label for="updateDescription" class="col-lg-2 control-label">Info</label>
                <div class="col-lg-10">
                    <textarea class="form-control" name="description" id="updateDescription" cols="10" rows="5" placeholder="Provide short descriptions of changes in this release. Include anything breaking or anything you find important."></textarea>
                    <p class="help-block">Anchors allowed.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="importance" class="col-lg-2 control-label">Rank</label>
                <div class="col-lg-10">
                    @foreach(UpdateRank::orderBy('rank', 'asc')->get() as $rank)
                    <label for="rank-{{ $rank->id }}">
                        <input type="radio" name="rank" value="{{ $rank->id }}" id="rank-{{ $rank->id }}"> {{ $rank->name }}
                    </label>
                    <br>
                    @endforeach
                    <p class="help-block">Rank tells us when to send the notification out. </p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </div>
            </div>
            {{ Form::close() }}


            <hr>
            @endif
        @endif


        <h3>Project Updates</h3>
        <br>

    </div>


</div>

@stop
