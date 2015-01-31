@extends('layouts/master')

@section('content')


    <h2>Ooops! <small>There was a problem submitting your feedback.</small></h2>
    <p>If you're still interested send us an email at support@patchnotes.org</p>

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>

@stop
