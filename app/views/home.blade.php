@extends('layouts/master')

@section('title', "PatchNotes")

@section('precontent')
    @if(!Sentry::check())

        <div id="pullEmIn" class="jumbotron hero-spacer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Filling this in was the the hardest thing I did on the website -->
                        <h1 id="lead">Keep up with the software world</h1>

                        <h2 id="sublead">WIP.</h2>

                        <p>Never let that security vulnerability bite you in the butt again or something</p>
                    </div>
                    <div class="col-lg-4">
                        {{ Form::open(array('url' => 'account/register', 'class' => 'form auth', 'role' => 'form')) }}
                        <input class="form-control" name="username" placeholder="Username" type="text"/>
                        <input class="form-control" name="email" placeholder="Email" type="email"/>
                        <input class="form-control" name="password" placeholder="Password" type="password"/>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Create An Account
                        </button>

                        <p>By clicking "Create an Account", you agree to our <a href="/about/tos">Terms of Service</a> &
                            <a
                                    href="/about/privacy">Privacy Policy</a>.</p>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('content')

    <div id="feature-cycle" class="row">
        <div id="feature-producer" class="col-md-5 col-md-offset-1">
            <h2>Producers: <em class="feature-topic"></em></h2>

            <p class="feature-text"></p>
        </div>
        <div id="feature-consumer" class="col-md-5">
            <h2>Consumers: <em class="feature-topic"></em></h2>

            <p class="feature-text"></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>Newest Projects</h3>
        </div>
    </div><!-- /.row -->

    @include('projects/partials/list', ['projects' => $newProjects])

@stop

@section('scripts')
    <script>
        $(function documentReady() {
            var featureCycles = {
                topics: ["Security Alerts", "Bug Fixes"],
                producers: {
                    "Security Alerts": "Here's something for the producers",
                    "Bug Fixes": "Something about bug fixes for producers."
                },
                consumers: {
                    "Security Alerts": "Be informed instantly when projects you use have important security patches.",
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
                if (currentCycle > (featureCycles.topics.length - 1)) {
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