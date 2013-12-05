@extends('layouts/master')

@section('content')

<div class="update">
    <h3>{{{ $update->title }}}</h3>
    <p>{{{ $update->body }}}</p>

    <hr>

    <p>
        Posted by: <a href="/user/{{{ $update->author->username }}}">{{{ $update->author->username }}}</a> 
        for <a href="/projects/{{ $project->slug }}">{{{ $project->name }}}</a> 
        on {{ $update->created_at->toRSSString() }}
    </p>

</div>


@stop
