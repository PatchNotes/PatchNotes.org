@extends('layouts.master')

@section('title')
Forgot Password
@stop

@section('navigation')

@stop

@section('content')
<div class="row">
    <div class="span6">
        <h3>Forgot Password</h3>


        @if($errors->count() > 0)
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(array('url' => 'account/forgot', 'class' => 'form-horizontal')) }}
        <fieldset>

            <div class="control-group">
                <!-- Username -->
                <label class="control-label" for="email">Email</label>

                <div class="controls">
                    <input type="text" id="email" name="email" placeholder="" class="input-xlarge" tabindex="1">
                </div>
            </div>

            <div class="control-group">
                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-success">Reset</button>
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>

</div>
@stop
