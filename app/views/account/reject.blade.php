@extends('layouts.master')

@section('content')

<h3>OAuth Authentication Rejected</h3>
<p>There was either a problem during your request or you rejected our authentication attemps. </p>

<h4>Worried About Permissions?</h4>
<p>Unfortunately GitHub and BitBucket only have large scope permissions which means when we want your email and username, we have to request a lot more then should be required.</p>

@stop
