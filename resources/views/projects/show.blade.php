@extends('layouts/master')

@section('title', $project->name . " on PatchNotes")

@section('head')
    <meta name="author" content="{{ $owner->name }}"/>
    <meta name="description" content="{{ $project->description }}"/>
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2 id="projectHeader">
            @if(!Sentry::check() || (Sentry::check() && !$project->isSubscriber(Sentry::getUser())))
                <a href="{{ action('Projects\\SubscriptionController@store', array($owner->slug, $project->slug)) }}" class="btn subscribe-btn social-subscribe" data-csrf-token="{{ csrf_token() }}">
                    <i class="fa fa-plus"></i> <span class="text"></span>
                </a>
            @else
                <a href="{{ action('Projects\\SubscriptionController@destroy', array($owner->slug, $project->slug)) }}" class="btn subscribe-btn social-unsubscribe" data-csrf-token="{{ csrf_token() }}">
                    <i class="fa fa-minus"></i> <span class="text"></span>
                </a>
            @endif
            <a href="{{ $owner->href }}">{{ $owner->name }}</a> / <a href="{{ $project->href }}">{{ $project->name }}</a>
            <br><small><a href="{{ $project->site_url }}" target="_blank">{{ $project->site_url }}</a></small>
        </h2>
    </div>
</div>


<div class="row">

    <div class="col-lg-7">
        <p>{{ $project->description }}</p>

        <div class="panel panel-default">
            <div class="panel-heading">Recent Project Updates</div>
            <div class="panel-body">

                @if(count($project->updates()->get()) == 0)
                <p>Nothing yet, subscribe to be notified of project updates.</p>
                @else
                <div class="panel-group" id="accordion">
                    <?php $first = 'in'; ?>
                    @foreach($project->updates()->orderby('created_at', 'desc')->get() as $update)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $update->id }}">
                                    {{ $update->title }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{ $update->id }}" class="panel-collapse collapse {{ $first }}">
                            <div class="panel-body">
                                {{ $update->body }}

                                <hr>
                                <p><a href="{{ action('Projects\\UpdateController@show', array($owner->slug, $project->slug, $update->slug)) }}">{{ $update->created_at->toRSSString() }}</a></p>
                            </div>
                        </div>
                    </div>
                    <?php $first = ''; ?>
                    @endforeach
                </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-lg-5">

        @if(Sentry::check())
        <div id="subscribe" class="panel panel-primary" style="display:none">
            <div class="panel-heading">Subscribed to {{ $project->name }}</div>
            <div class="panel-body">
                <p>Thanks for your subscription to {{ $project->name }}. Your default subscription intervals are below, you can also modify them on
                    <a href="/account/dashboard">your dashboard</a>.</p>

                <ul>
                    <li>Newsletter: {{ Sentry::getUser()->getDefaultNotificationLevel(10)->name }}</li>
                    <li>Product Updates: {{ Sentry::getUser()->getDefaultNotificationLevel(50)->name }}</li>
                    <li>Service Changes: {{ Sentry::getUser()->getDefaultNotificationLevel(100)->name }}</li>
                </ul>
            </div>
        </div>
        <div id="unsubscribe" class="panel panel-primary" style="display:none">
            <div class="panel-heading">Unsubcribed to {{ $project->name }}</div>
            <div class="panel-body">
                <p>All of your subscriptions to {{ $project->name }} have been removed. You won't receive any more emails.</p>
            </div>
        </div>
        @endif

        <div class="row text-center">
            <div class="col-sm-4">
                <div class="well well-sm">
                    Subscriptions <br>
                    <h3>{{ $project->subscriberCount() }}</h3>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="well well-sm">
                    Updates <br>
                    <h3>{{ $project->updates()->count() }}</h3>
                </div>
            </div>
            <div class="col-sm-4">
                <a href="{{ $project->href }}/updates.rss" class="btn social-btn social-rss">
                    <i class="fa fa-rss"></i>
                </a>
                <a href="" class="btn social-btn social-code">
                    <i class="fa fa-code"></i>
                </a>
                <a href="{{ $project->share('twitter') }}" class="btn social-btn share-btn social-twitter share" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="{{ $project->share('google') }}" class="btn social-btn share-btn social-google share" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
            </div>
        </div>


            <div id="code" class="panel panel-default" style="display:none">
                <div class="panel-heading">Embed Widget Code</div>
                <div class="panel-body">
                    <p>You can use this code to embed our subscription widget on your website.</p>
                    <pre>Some code here.</pre>
                </div>
            </div>


        @if(Sentry::check())
            @if(Sentry::getUser()->isMember($project))
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


                        {!! Form::open(array('action' => array('Projects\\UpdateController@store', $owner->slug, $project->slug), 'class' => 'form-horizontal', 'role' => 'form')) !!}
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
                                @foreach(PatchNotes\Models\ProjectUpdateLevel::orderBy('level', 'asc')->get() as $rank)
                                <label for="level-{{ $rank->level }}" data-toggle="tooltip" data-placement="right" title="{{ Lang::get('project.project_update_level.' . $rank->level) }}">
                                    <input type="radio" name="level" value="{{ $rank->level }}" id="level-{{ $rank->level }}"> {{ $rank->name }}
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
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
        @endif

    </div>

</div>

@stop
