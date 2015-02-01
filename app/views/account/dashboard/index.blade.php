@extends("layouts/master")

@section('title', "Your Dashboard")

@section("content")

<div class="row">
    <div class="col-md-3">
        @include("account/dashboard/partials/nav")
    </div>
    <div class="col-md-9">
        <h4>Your Projects</h4>
        @include('projects/partials/list', ['projects' => $user->projects])


        <h4>Your Organizations</h4>
        @include('organizations/partials/list', ['organizations' => $user->organizations])
    </div>
</div>



@stop