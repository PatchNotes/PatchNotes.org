@extends('layouts/master')

@section('content')
<div class="jumbotron hero-spacer">
    <h1>Welcome to PatchNotes</h1>

    <p>Introduce your website content using this jumbotron! It's an awesome way to call attention to something that needs to be read! It's also a great alternative to using a banner image if you don't have a good quality picture!</p>

    <p><a class="btn btn-primary btn-large">Call to action!</a></p>
</div>

<hr>

<div class="row">
    <div class="col-lg-12">
        <h3>Newest Projects</h3>
    </div>
</div><!-- /.row -->

<div class="row text-center">

    <div class="col-lg-3 col-md-6 hero-feature">
        <div class="thumbnail">
            <img src="http://www.robothumb.com/src/?url=http://getbootstrap.com&size=800x500" alt="">
            <div class="caption">
                <h3>Bootstrap</h3>
                <p>This would be a great spot to feature some brand new products!</p>
                <p><a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a></p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 hero-feature">
        <div class="thumbnail">
            <img src="http://www.robothumb.com/src/?url=http://laravel.com&size=800x500" alt="">
            <div class="caption">
                <h3>Laravel</h3>
                <p>This would be a great spot to feature some brand new products!</p>
                <p><a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a></p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 hero-feature">
        <div class="thumbnail">
            <img src="http://www.robothumb.com/src/cnamer.com@800x500.jpg" alt="">
            <div class="caption">
                <h3>CNamer</h3>
                <p>This would be a great spot to feature some brand new products!</p>
                <p><a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a></p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 hero-feature">
        <div class="thumbnail">
            <img src="http://placehold.it/800x500" alt="">
            <div class="caption">
                <h3>Feature Label</h3>
                <p>This would be a great spot to feature some brand new products!</p>
                <p><a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a></p>
            </div>
        </div>
    </div>


</div><!-- /.row -->


<div class="row">
    <div class="col-lg-12">
        <h3>Upcoming Projects</h3>
    </div>
</div><!-- /.row -->
@stop
