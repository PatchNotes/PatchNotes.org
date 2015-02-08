@extends('layouts/master')

@section('title', "Create an Organization")

@section('content')

<div class="row">
    <div class="col-lg-6">
        {!! BootForm::open()->action(action("OrganizationController@store"))->render() !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            {!! BootForm::text('Organization Name', 'name')->autofocus('autofocus') !!}
            {!! BootForm::text('Organization Email', 'email') !!}
            {!! BootForm::text('Organization URL', 'site_url') !!}
            {!! BootForm::textarea('Organization Description', 'description')->placeholder("A description or your organization or group. Completely optional.") !!}

            {!! BootForm::submit('Create Organization') !!}
        {!! BootForm::close() !!}
    </div>
    <div class="col-lg-6">
        @if($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>


@stop
