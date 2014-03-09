@extends('layouts/master')

@section('content')

<div class="row">
    <div class="col-lg-6">
        {{ BootForm::open()->action(action("OrganizationController@store"))->render() }}
            {{ BootForm::text('Organization Name', 'name') }}
            {{ BootForm::text('Organization URL', 'site_url') }}
            {{ BootForm::textarea('Organization Description', 'description')->placeholder("A description or your organization or group. Completely optional.") }}

            {{ BootForm::submit('Create Organization') }}
        {{ BootForm::close() }}
    </div>
</div>


@stop
