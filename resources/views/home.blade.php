@extends('layouts/master')

@section('title', "PatchNotes")

@section('head')
    <meta name="description" content="Regular email updates from the projects and services you use."/>
@stop

@section('precontent')
    @if(!Sentry::check())

        {{--<div id="pullEmIn" class="jumbotron hero-spacer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <br/>
                        <!-- Filling this in was the the hardest thing I did on the website -->
                        <h1 id="lead">Software Changes Fast</h1>
                        <h2 id="sublead">Keep up with regular email updates from the projects and services you rely on.</h2>
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
        </div>--}}
        <div id="pullEmIn" class="jumbotron hero-spacer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <br/>
                        <!-- Filling this in was the the hardest thing I did on the website -->
                        <h1 id="lead">Software Changes Fast</h1>

                        <h2 id="sublead">Keep up with regular email updates from the projects and services you rely
                            on.</h2>
                    </div>
                    <div class="col-lg-5">
                        <img src="http://i.imgur.com/Z7qOGBP.png" class="img-responsive visible-lg" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3>Newest Projects</h3>
        </div>
    </div><!-- /.row -->

    @include('projects/partials/list', ['projects' => $newProjects])

@stop

@section('scripts')

@stop