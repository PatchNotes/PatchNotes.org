@extends('layouts/master')

@section('title', $org->name . " on PatchNotes")

@section('content')


    <h2>{{{ $org->name }}}</h2>
    <div class="row">
        <div class="col-md-3">
            <ul>
                <li>Created On: {{ $org->created_at }}</li>
            </ul>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <h3>Projects</h3>
            @include('projects/partials/list', ['projects' => $org->projects])
        </div>
    </div>

@stop
