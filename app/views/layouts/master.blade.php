<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PatchNotes</title>

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">

        @foreach(Config::get('patchnotes.assets.styles') as $style)
        {{ HTML::style($style . (App::environment() == 'local' ? '.css' : '.min.css')) }}
        @endforeach

        <style>
            body {
                margin-top: 50px; /* 50px is the height of the navbar - change this if the navbarn height changes */
            }
            .hero-spacer {
                margin-top: 50px;
            }

            .hero-feature {
                margin-bottom: 30px;/* spaces out the feature boxes once they start to stack responsively */
            }

            footer {
                margin: 50px 0;
            }
        </style>
    </head>

    <body class="{{ (isset($bodyclass) ? $bodyclass : '' ) }}">

        <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">PatchNotes</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/projects">Projects</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>

                    @if(!Sentry::check())
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="/account/register">Register</a></li>
                        <li><a href="/account/login">Login</a></li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="/panel">Account</a></li>
                        <li><a href="/account/logout">Logout</a></li>
                    </ul>
                    @endif

                    {{ Form::open(array('method' => 'get', 'url' => '/search', 'class' => 'navbar-form navbar-right', 'role' => 'search')) }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="query" placeholder="Search">
                        </div>
                    {{ Form::close() }}

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>

        <div class="container">

            @yield('content')



            <hr>

            <footer>
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            Copyright &copy; Axxim, LLC 2013 &middot;
                            <a href="http://twitter.com/patchnotes">Twitter</a>
                        </p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <p>
                            <a href="/about/tos">Terms of Service</a> &middot;
                            <a href="/about/privacy">Privacy Policy</a>
                        </p>
                    </div>
                </div>
            </footer>

        </div><!-- /.container -->

        @foreach(Config::get('patchnotes.assets.scripts') as $script)
        {{ HTML::script($script . (App::environment() == 'local' ? '.js' : '.min.js')) }}
        @endforeach
    </body>

</html>
