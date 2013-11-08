@extends('layouts.master')

@section('title')
Reset Password
@stop

@section('navigation')

@stop

@section('content')
<div class="row">
    <div class="span6">
        <h3>Reset Password</h3>


        @if($errors->count() > 0)
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(array('url' => 'account/reset', 'class' => 'form-horizontal')) }}
        <fieldset>

            <input type="hidden" name="code" value="{{$code}}"/>
            <input type="hidden" name="email" value="{{$email}}"/>

            <div class="control-group">
                <!-- Password-->
                <label class="control-label" for="password">Password</label>

                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="" class="input-xlarge" tabindex="3">

                    <p class="help-block">Password should be at least 6 characters</p>
                </div>
            </div>

            <div class="control-group">
                <!-- Password -->
                <label class="control-label" for="password_confirm">Password (Confirm)</label>

                <div class="controls">
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge" tabindex="4">

                    <p class="help-block">Please confirm your password</p>
                </div>
            </div>

            <div class="control-group">
                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-success">Finalize</button>
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>

</div>
@stop
