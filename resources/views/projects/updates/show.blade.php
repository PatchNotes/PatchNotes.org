@extends('layouts/master')

@section('title', $project->name . ": " .$update->title)

@section('content')

<div class="update">
    <h3>{{{ $update->title }}}</h3>
    <p>{{{ $update->body }}}</p>

    <hr>

    <p>
        Posted by: <a href="{{ $update->author->href }}">{{{ $update->author->username }}}</a>
        for <a href="{{ $project->href }}">{{{ $project->name }}}</a>
        on {{ $update->created_at->toRSSString() }}
    </p>

</div>


@stop
