@extends('layouts/master')

@section('content')

<style>
    #projectBody {
        font-family: monospace;
    }
</style>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h2>Add a Project</h2>

        @if($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(array('action' => 'ProjectController@store', 'class' => 'form-horizontal', 'role' => 'form')) }}
        <div class="form-group">
            <label for="projectName" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="name" id="projectName" placeholder="Minotar">
            </div>
        </div>
        <div class="form-group">
            <label for="projectURL" class="col-lg-2 control-label">URL</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="url" id="projectURL" placeholder="https://github.com/axxim/minotar">
            </div>
        </div>
        <div class="form-group">
            <label for="projectDescription" class="col-lg-2 control-label">Description</label>
            <div class="col-lg-10">
                <textarea class="form-control" name="description" id="projectDescription" cols="10" rows="2" placeholder="A short description of your project or service."></textarea>
                <p class="help-block">
                    Markdown not allowed.
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="projectBody" class="col-lg-2 control-label">Body</label>
            <div class="col-lg-10">
                <textarea class="form-control" name="body" id="projectBody" cols="10" rows="5" placeholder="Additional information about your project, your readme or something you find appropriate."></textarea>
                <p class="help-block">
                    Markdown allowed.
                </p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary">Create Project</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>


@stop
