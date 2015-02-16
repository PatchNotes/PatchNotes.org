@extends('layouts/master')

@section('title', "PatchNotes")

@section('head')
    <meta name="description" content="Regular email updates from the projects and services you use."/>
@stop

@section('precontent')
        {{--<div id="pullEmIn" class="jumbotron hero-spacer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <br/>
                        <!-- Filling this in was the the hardest thing I did on the website -->
                        <h1 id="lead">Software Changes Fast</h1>
                        <h2 id="sublead">Keep up with regular email updates from the projects and services you rely on.</h2>
                    </div>
                    <div class="col-lg-4">
                        {{ Form::open(array('url' => 'account/register', 'class' => 'form auth', 'role' => 'form')) }}
                        <input class="form-control" name="username" placeholder="Username" type="text"/>
                        <input class="form-control" name="email" placeholder="Email" type="email"/>
                        <input class="form-control" name="password" placeholder="Password" type="password"/>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Create An Account
                        </button>

                        <p>By clicking "Create an Account", you agree to our <a href="/about/tos">Terms of Service</a> &
                            <a
                                    href="/about/privacy">Privacy Policy</a>.</p>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>--}}

        <div id="pullEmIn">
            <canvas id="blorbs" class="visible-lg visible-md"></canvas>

            <div id="blorbs-overlay">
                <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <!-- Filling this in was the the hardest thing I did on the website -->
                        <h1 id="lead">Software Changes Fast</h1>

                        <h2 id="sublead">Keep up with regular email updates from the projects and services you rely
                            on.</h2>
                    </div>
                    <div class="col-lg-5">
                        <img src="http://i.imgur.com/Z7qOGBP.png" class="img-responsive visible-lg" alt=""/>
                    </div>
                </div>
                </div>
            </div>
        </div>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3>Newest Projects</h3>
        </div>
    </div><!-- /.row -->

    @include('projects/partials/list', ['projects' => $newProjects])

@stop

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.1/plugins/CSSPlugin.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.1/easing/EasePack.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.1/TweenLite.min.js"></script>
    <script>
        var canvas = document.getElementById('blorbs');

        var ctx = canvas.getContext('2d');

        var width = window.innerWidth;
        var height = 286;

        canvas.width = width;
        canvas.height = height;

        window.onresize = function () {
            width = window.innerWidth;
            height = 286;
            canvas.width = width;
            canvas.height = height;

        };

        function Circle(x, y) {

            this.x = x + Math.random() * width / 20;
            this.y = y + Math.random() * height / 20;
            this.originX = this.x;
            this.originY = this.y;
            this.radius = (Math.random() * Math.PI) * 4;
            this.shadowBlur = Math.floor(Math.random() * 50) + 15;
            this.alpha = 1;

            if (this.radius > 8) {
                this.color = '#5bc0de';
            } else {
                this.color = '#43ac6a';
            }
        }

        Circle.prototype.shiftPoint = function () {
            var self = this;
            TweenLite.to(this, 1 + Math.random(), {
                x: this.originX + 50 + Math.random() * 50,
                y: this.originY - 50 + Math.random() * 50,

                ease: Power4.easeInOut,
                onComplete: function () {
                    self.shiftPoint();
                }
            });
        };

        Circle.prototype.draw = function () {

            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = this.color;
            ctx.shadowBlur = this.shadowBlur;
            ctx.shadowColor = this.color;
            ctx.fill();

        };

        Circle.prototype.getDistanceTo = function (x, y) {
            var xs = 0;
            var ys = 0;

            xs = x - this.x;
            xs = xs * xs;

            ys = y - this.y;
            ys = ys * ys;

            return Math.sqrt(xs + ys);
        };


        var bigCircles = [],
                smallCircles = [];


        for (var x = 0; x < width; x = x + width / 30) {
            for (var y = 0; y < height; y = y + height / 10) {
                var ball = new Circle(x, y);

                if(ball.radius > 8) {
                    bigCircles.push(ball);
                }
            }
        }

        for (var x = 0; x < width; x = x + width / 30) {
            for (var y = 0; y < height; y = y + height / 10) {
                var ball = new Circle(x, y);
                var parent = bigCircles[Math.floor(Math.random()*bigCircles.length)];

                if(ball.radius < 8) {
                    ball.shiftPoint();
                    ball.parent = parent;
                    smallCircles.push(ball);
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);

            for (var i = 0; i < smallCircles.length; i++) {
                var current = smallCircles[i];
                var distance = current.getDistanceTo(current.parent.x, current.parent.y);
                if (distance > 200 && distance < 400) {
                    if (current.x > current.parent.x) {
                        current.originX -= 7;
                    } else {
                        current.originX += 7;
                    }

                    if (current.y > current.parent.y) {
                        current.originY -= 7;
                    } else {
                        current.originY += 7;
                    }

                }

                current.draw();
            }


            for (var bi = 0; bi < bigCircles.length; bi++) {
                bigCircles[bi].draw();
            }
            requestAnimationFrame(animate);
        }

        animate();
    </script>
@stop