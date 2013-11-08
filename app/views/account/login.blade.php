@extends('layouts.master')

@section('content')

<style>
    .form-control { margin-bottom: 10px; }
</style>

<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <h2>Login</h2>

        <div class="account-wall">
            @if($errors->count() > 0)
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
            @endif

            {{ Form::open(array('url' => 'account/login', 'class' => 'form-login')) }}
            <input type="text" class="form-control" placeholder="Email" name="email" required autofocus>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Beam Me Up
            </button>
            <span class="clearfix"></span>
            {{ Form::close() }}
        </div>
        <div class="text-center">
            <br/>
            <a href="/account/register">Create an account</a>
        </div>

    </div>
</div>
@stop
