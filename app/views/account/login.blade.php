@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h2>Login</h2>

        @if($errors->count() > 0)
		<ul>
		    @foreach($errors->all() as $message)
		    <li>{{$message}}</li>
		    @endforeach
		</ul>
		@endif

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
</div>
