@extends('layouts/master')

@section('content')

<h2>{{{ $project->name }}}<br><small><a href="{{ $project->site_url }}" target="_blank">{{{ $project->site_url }}}</a></small></h2>
<div class="row">

    <div class="col-lg-7">
        <p>{{{ $project->description }}}</p>

        <div class="well">
            {{ $parser->transformMarkdown($project->content) }}
        </div>
    </div>
    <div class="col-lg-5">
        @if(Sentry::check())
            @if($project->isManager(Sentry::getUser()))
                <div class="panel panel-default">
                    <div class="panel-heading">New Project Update</div>
                    <div class="panel-body">
                        @if($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $message)
                                <li>{{$message}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        {{ Form::open(array('action' => array('PatchNotes\\Controllers\\Projects\\UpdateController@store', $project->name), 'class' => 'form-horizontal', 'role' => 'form')) }}
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
                                <textarea class="form-control" name="description" id="updateDescription" cols="10" rows="5" placeholder="Let the user know exactly what they need to know, include links for additional info or anything else you find important for the update."></textarea>
                                <p class="help-block">Anchors allowed.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="importance" class="col-lg-2 control-label">Level</label>
                            <div class="col-lg-10">
                                @foreach(SubscriptionLevel::orderBy('level', 'asc')->get() as $rank)
                                <label for="rank-{{ $rank->level }}" data-toggle="tooltip" data-placement="right" title="{{ Lang::get('project.notification_levels.' . $rank->level) }}">
                                    <input type="radio" name="rank" value="{{ $rank->level }}" id="rank-{{ $rank->level }}"> {{ $rank->name }}
                                </label>
                                <br>
                                @endforeach

                                <p class="help-block">The level tells us when to send the notifications out to users. </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Project Updates</div>
            <div class="panel-body">
                <p>None yet.</p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Project Managers</div>
            <div class="panel-body">
                @foreach($project->managers as $manager)
                <a href="/users/{{{ $manager->user->username }}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{{ $manager->user->username }}}'s Avatar">
                    <img src="{{ $manager->user->getGravatar() }}" alt="{{{ $manager->user->username }}}'s Avatar"/>
                </a>
                @endforeach
            </div>
        </div>

    </div>


</div>

@stop
