@extends('layouts/master')

@section('content')

    <h3>You're Unsubscribed</h3>
    <p>Thanks for using PatchNotes, we're sorry you didn't like our service. If you have any feedback please let us know below:</p>

    <br/><br/>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            {{ Form::open(['action' => 'HomeController@postUnsubscribeFeedback', 'method' => 'POST']) }}

            {{ Form::hidden('email', Input::get('email')) }}
            {{ Form::textarea('feedback', null, ['class' => 'form-control', 'autofocus']) }}
            <br/>
            {{ Form::submit('Send Feedback', ['class' => 'btn btn-primary form-control']) }}

            {{ Form::close() }}
        </div>
    </div>

@stop
