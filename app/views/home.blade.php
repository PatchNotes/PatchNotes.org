@extends('layouts/master')

@section('content')

@if(!Sentry::check())
<div id="pullEmIn" class="jumbotron hero-spacer">
    <div class="row">
        <div class="col-lg-8">
            <h1 id="lead">Development changes fast</h1>
            <h2 id="sublead">PatchNotes helps you keep up</h2>

            <p>This is a catchy message in order to help you to want to use our service. It should be about this length
            with several clear sentences and points. Almost there now, we can do it. Yes, there we go.</p>
        </div>
        <div class="col-lg-4">
            {{ Form::open(array('url' => 'account/register', 'class' => 'form auth', 'role' => 'form')) }}
            <input class="form-control" name="username" placeholder="Username" type="text"/>
            <input class="form-control" name="email" placeholder="Email" type="email"/>
            <input class="form-control" name="password" placeholder="Password" type="password"/>

            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Create An Account
            </button>

            <p>By clicking "Create an Account", you agree to our <a href="/about/tos">Terms of Service</a> & <a
                    href="/about/privacy">Privacy Policy</a>.</p>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif

<p class="text-info">These divs below should swap out for the various focuses PatchNotes has.</p>
<div id="feature-cycle" class="row">
    <div id="feature-producer" class="col-lg-6">
        <h2>Producers: <em class="feature-topic"></em></h2>
        <p class="feature-text"></p>
    </div>
    <div id="feature-consumer" class="col-lg-6">
        <h2>Consumers: <em class="feature-topic"></em></h2>
        <p class="feature-text"></p>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <h3>Newest Projects</h3>
    </div>
</div><!-- /.row -->

<?php $projects = $newProjects; ?>
@include('projects/partials/list')

@stop

@section('scripts')
<script>
$(function documentReady() {
    var featureCycles = {
        topics: ["Security Alerts","Bug Fixes"],
        producers: {
            "Security Alerts": "Here's something for the producers",
            "Bug Fixes": "Something about bug fixes for producers."
        },
        consumers: {
            "Security Alerts": "Here's something for the consumers",
            "Bug Fixes": "Something about bug fixes for consumers."
        }
    };

    var cycleInterval = 0,
        currentCycle = 0;

    function startCycle() {
        cycleInterval = setInterval(changeCycle, 10000);
    }

    function stopCycle() {
        clearInterval(cycleInterval);
    }

    function changeCycle() {
        currentCycle++;
        if(currentCycle > (featureCycles.topics.length - 1)) {
            currentCycle = 0;
        }

        setFeature(currentCycle);
    }

    function setFeature(i) {
        var currentTopic = featureCycles.topics[currentCycle];

        $('#feature-producer').find('.feature-topic').text(currentTopic);
        $('#feature-producer').find('.feature-text').text(featureCycles.producers[currentTopic]);

        $('#feature-consumer').find('.feature-topic').text(currentTopic);
        $('#feature-consumer').find('.feature-text').text(featureCycles.consumers[currentTopic]);
    }

    setFeature(0);
    startCycle();

    $('#featureCycle').hover(function cycleHover() {
        stopCycle();
    }, function cycleUnhover() {
        startCycle();
    });
});
</script>
@stop