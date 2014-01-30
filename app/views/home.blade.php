@extends('layouts/master')

@section('content')


<div id="pullEmIn" class="jumbotron hero-spacer">
	<div class="row">
		<div class="col-lg-8">
			<h1 id="lead">Development changes fast</h1>
			<h2 id="sublead">PatchNotes helps you keep up</h2>

			<p>Here's some other bullshit to pull you into our product and tell you more about the service at the same
				time.</p>
		</div>
		<div class="col-lg-4">
			{{ Form::open(array('url' => 'account/register', 'class' => 'form auth', 'role' => 'form')) }}
			<input class="form-control" name="username" placeholder="Username" type="text"/>
			<input class="form-control" name="email" placeholder="Email" type="email"/>
			<input class="form-control" name="password" placeholder="Password" type="password"/>

			<button class="btn btn-lg btn-primary btn-block" type="submit">
				Create An Account
			</button>

			<p>By clicking "Create an Account", you agree to our <a href="/about/tos">Terms of Service</a> & <a
					href="/about/privacy">Privacy Policy</a>.</p>
			{{ Form::close() }}
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<h2>For Project Maintainers</h2>
	</div>
	<div class="col-lg-6">
		<h2>For Project Followers</h2>

	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h3>Newest Projects</h3>
	</div>
</div><!-- /.row -->

<?php $projects = $newProjects; ?>
@include('projects/partials/list')

@stop
