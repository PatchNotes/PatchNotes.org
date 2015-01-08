@extends('layouts/master')

@section('content')


    <h2>{{{ $org->name }}}</h2>
    <div class="row">
        <div class="col-md-3">
            <ul>
                <li>Created On: {{ $org->created_at }}</li>
            </ul>
            <img src="" alt="">
        </div>
        <div class="col-md-8 col-md-offset-1">
            <h3>Projects</h3>
            <?php $projects = $org->projects; ?>
            @include('projects/partials/list')
        </div>
    </div>

@stop
