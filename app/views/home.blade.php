@extends('layouts/master')

@section('content')
<div class="jumbotron hero-spacer">
    <h1>Welcome to PatchNotes</h1>

    <p>PatchNotes is a central subscription service for your favorite projects & services.</p>

    <p><a class="btn btn-primary btn-large">Call to action!</a></p>
</div>

<hr>

<div class="row">
    <div class="col-lg-12">
        <h3>Newest Projects</h3>
    </div>
</div><!-- /.row -->

<?php $projects = $newProjects; ?>
@include('projects/partials/list')

@stop
