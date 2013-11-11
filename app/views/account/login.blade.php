@extends('layouts.master')

@section('content')

@if($errors->count() > 0)
<ul>
    @foreach($errors->all() as $message)
    <li>{{$message}}</li>
    @endforeach
</ul>
@endif

<div class="row">
    <div class="col-lg-5">
        <h2>Login</h2>

        <div class="account-wall">
            {{ Form::open(array('url' => 'account/login', 'class' => 'form-login auth')) }}
            <input type="text" class="form-control" placeholder="Email" name="email" required autofocus>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Login
            </button>
            <span class="clearfix"></span>
            {{ Form::close() }}
        </div>
    </div>

    <div class="col-lg-5 col-lg-offset-2">
        <h2>Create An Account</h2>
        <p>You'll be able to use this account to both add services and subscribe to existing ones. You'll need a valid email.</p>

        {{ Form::open(array('url' => 'account/register', 'class' => 'form auth', 'role' => 'form')) }}
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
