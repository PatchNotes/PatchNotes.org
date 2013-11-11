<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PatchNotes</title>

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        {{ stylesheet_link_tag() }}
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login / Register <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/account/auth/github"><i class="fa fa-github"></i> GitHub</a></li>
                                <li><a href="/account/login"><i class="fa fa-user"></i> Email</a></li>
                            </ul>
                        </li>
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
                            <a target="_blank" href="http://twitter.com/patchnotes">Twitter</a> &middot;
                            <a target="_blank" href="https://github.com/PatchNotes/PatchNotes.org">GitHub</a>
                        </p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <p>
                            <a href="/about/tos">Terms of Service</a> &middot;
                            <a href="/about/privacy">Privacy Policy</a>
                        </p>
                    </div>
                </div>
                <p class="text-center">
                    PatchNotes is an Open Company &middot; Crafted in Dallas, TX
                </p>
            </footer>

        </div><!-- /.container -->

        {{ javascript_include_tag() }}
    </body>

</html>
