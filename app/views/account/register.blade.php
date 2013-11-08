@extends('layouts.master')

@section('content')

<style>
    .form-control { margin-bottom: 10px; }
</style>

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h2>Create An Account</h2>
        <p>You'll be able to use this account to both add services and subscribe to existing ones. You'll need a valid email.</p>

        @if($errors->count() > 0)
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(array('url' => 'account/register', 'class' => 'form', 'role' => 'form')) }}
        <input class="form-control" name="username" placeholder="Username" type="text" />
        <input class="form-control" name="email" placeholder="Email" type="email" />
        <input class="form-control" name="password" placeholder="Password" type="password" />

        <p>Please review our <a href="/about/tos">Terms of Service</a> before your create your account.</p>

        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Create An Account
        </button>
        {{ Form::close() }}
        <div class="text-center">
            <br/>
            <a href="/account/login">Login</a>
        </div>
    </div>
</div>


@stop
