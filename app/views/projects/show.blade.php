@extends('layouts/master')

@section('content')

<div class="row">
    <div class="col-lg-7">
        <h2>{{{ $project->name }}}<br><small><a href="{{ $project->site_url }}" target="_blank">{{{ $project->site_url }}}</a></small></h2>
    </div>
    <div class="col-lg-5">
        <a href="/projects/{{ $project->slug }}/updates.rss" class="btn social-btn social-rss"><i class="fa fa-rss"></i></a>
        <a href="{{ action('Projects\\ShareController@getFacebook', array($project->slug)) }}" class="btn social-btn share-btn social-facebook" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="{{ action('Projects\\ShareController@getTwitter', array($project->slug)) }}" class="btn social-btn share-btn social-twitter" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="{{ action('Projects\\ShareController@getGoogle', array($project->slug)) }}" class="btn social-btn share-btn social-google" target="_blank"><i class="fa fa-google-plus"></i></a>
        <a href="" class="btn social-btn social-code"><i class="fa fa-code"></i></a>
    </div>
</div>


<div class="row">

    <div class="col-lg-7">
        <p>{{{ $project->description }}}</p>

        <div class="panel panel-default">
            <div class="panel-heading">Recent Project Updates</div>
            <div class="panel-body">

                <div class="panel-group" id="accordion">
                    <?php $first = 'in'; ?>
                    @foreach($project->updates()->orderby('created_at', 'desc')->get() as $update)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $update->id }}">
                                    {{{ $update->title }}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{ $update->id }}" class="panel-collapse collapse {{ $first }}">
                            <div class="panel-body">
                                {{{ $update->body }}}
                                
                                <hr>
                                <p><a href="{{ action('Projects\\UpdateController@show', array($project->slug, $update->slug)) }}">{{ $update->created_at->toRSSString() }}</a></p>
                            </div>
                        </div>
                    </div>
                    <?php $first = ''; ?>
                    @endforeach

                </div>
                
            </div>
        </div>
    </div>
    <div class="col-lg-5">

        <div id="code" class="panel panel-default" style="display:none">
            <div class="panel-heading">Embed Widget Code</div>
            <div class="panel-body">
                <p>You can use this code to embed our subscription widget on your website.</p>
                <pre>Some code here.</pre>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="well well-sm">
                    Subscriptions <br>
                    <h3>100</h3>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="well well-sm">
                    Updates <br>
                    <h3>{{ count($project->updates) }}</h3>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="well well-sm">
                    Managers <br>
                    <h3>{{ count($project->managers) }}</h3>
                </div>
            </div>
        </div>

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


                        {{ Form::open(array('action' => array('Projects\\UpdateController@store', $project->slug), 'class' => 'form-horizontal', 'role' => 'form')) }}
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
                                <button type="submit" class="btn btn-primary">Post & Send Update</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Project Managers</div>
            <div class="panel-body">
                @foreach($project->managers as $manager)
                <a href="/users/{{{ $manager->user->username }}}">
                    <img src="{{ $manager->user->getGravatar() }}" alt="{{{ $manager->user->username }}}'s Avatar"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{{{ $manager->user->username }}}'s Avatar"/>
                </a>
                @endforeach
            </div>
        </div>

    </div>


</div>

@stop
