@extends('layouts/master')

@section('title', "Create a Project")

@section('scripts')
<script>
    $('.ghProject').click(function(event) {
        event.preventDefault();

        $('#projectName').val($(this).attr('data-gh-name'));
        $('#projectURL').val($(this).attr('data-gh-url'));
        $('#projectDescription').val($(this).attr('data-gh-description'));
    });
</script>
@stop

@section('content')

<style>
    #projectBody {
        font-family: monospace;
    }
</style>

<div class="row">
    <div class="col-lg-6">
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

        {!! BootForm::open()->action(action('Projects\\ProjectController@store'))->render() !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            {!! BootForm::select('Owner', 'owner', $possibleOwners) !!}
            {!! BootForm::text('Project Name', 'name')->id('projectName') !!}
            {!! BootForm::text('Homepage', 'url')->id('projectURL') !!}
            {!! BootForm::textarea('Short Description', 'description')->id('projectDescription')->rows(3) !!}
            {!! BootForm::submit('Create Project') !!}
        {!! BootForm::close() !!}
    </div>
    <div class="col-lg-6">
        @if(count($githubRepos) == 0)
            <p>No repositories found.</p>
        @else

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Your Github Repositories</h3>
            </div>
            <div class="panel-body" style="max-height: 300px; overflow-y:scroll">
                @foreach($githubRepos as $repo)
                <a href="#" data-gh-name="{{ $repo['name'] }}" data-gh-url="{{ $repo['html_url'] }}" data-gh-description="{{ $repo['description'] }}" class="ghProject">{{ $repo['full_name'] }}</a><br/>
                @endforeach
            </div>
        </div>

        @endif
    </div>
</div>


@stop
