<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PatchNotes</title>

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
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
                        <li>

                            {{ Form::open(array('method' => 'get', 'url' => '/search', 'class' => 'navbar-form', 'role' => 'search')) }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="query" placeholder="Search Projects & Users">
                            </div>
                            {{ Form::close() }}
                        </li>
                        <li><a href="/projects">Browse</a></li>
                        <li><a href="http://blog.patchnotes.org/">Blog</a></li>
                    </ul>

                    @if(!Sentry::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign Up / Sign In <b class="caret"></b></a>
                            <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                        	{{ Form::open(array('method' => 'post', 'url' => '/account/login', 'id' => 'login-nav', 'class' => 'form')) }}
                                                <div class="form-group">
                                                    <label class="sr-only" for="headerLoginEmail">Email address</label>
                                                    <input type="email" name="email" class="form-control" id="headerLoginEmail" placeholder="Email address" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="headerLoginPassword">Password</label>
                                                    <input type="password" name="password" class="form-control" id="headerLoginPassword" placeholder="Password" required>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> Remember me
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="login" class="btn btn-primary btn-block">Sign in</button>
                                                    <button type="submit" name="register" class="btn btn-success btn-block">Register</button>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    {{ Form::open(array('method' => 'post', 'url' => 'account/auth/github')) }}
                                    <input type="submit" class="btn btn-primary btn-block" id="sign-in-github" value="Sign in via GitHub">
                                    {{ Form::close() }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="/panel">Account</a></li>
                        <li><a href="/account/logout">Logout</a></li>
                    </ul>
                    @endif
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>

        <div id="content" class="container">

            @yield('content')

        </div>

        <div class="container">
            <hr/>
            <footer>
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            Copyright &copy; Axxim, LLC 2013 &middot;
                            <a target="_blank" href="http://twitter.com/patchnotesorg">Twitter</a> &middot;
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
                <div class="text-center">
                    PatchNotes is an Open Company &middot; Crafted in Dallas, TX <br>
                    <div data-gittip-username="PatchNotes" data-gittip-widget="custom">
                        PatchNotes is funded on <a class="gittip-profile-link" target="_blank"><span class="gittip-receiving">$0.00</span> / wk</a> via <a class="gittip-link" target="_blank">Gittip</a>.
                    </div>
                </div>
            </footer>

        </div><!-- /.container -->

        {{ javascript_include_tag() }}
        @yield('scripts')

        <script src="//gttp.co/v1.js"></script>
    </body>

</html>
