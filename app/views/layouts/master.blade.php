<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PatchNotes</title>

        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
        <link href="/assets/css/patchnotes.min.css" rel="stylesheet">
    </head>

    <body class="{{ (isset($bodyclass) ? $bodyclass : '' ) }}">

        <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            @if(App::environment() == 'production')
            <div class="alert alert-danger" role="alert" style="border-radius: 0; margin-bottom: 0;">
                <div class="container">
                    <div class="text-center">
                        <strong>Danger!</strong><br>
                        <p>This website is still "<em>under construction</em>" so things could be unreliable or completely broken. <br>
                        If you'd like to help out or just watch our progress, check us out <a href="https://github.com/PatchNotes/PatchNotes.org" target="_blank">on GitHub</a>.</p>
                    </div>
                </div>
            </div>
            @endif
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
                        <li><a href="/organizations">Organizations</a></li>
                        <li><a href="http://blog.patchnotes.org/">Blog</a></li>
                    </ul>

                    @if(!Sentry::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign Up / Sign In <b class="caret"></b></a>
                            <ul class="dropdown-menu account-menu">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ Form::open(array('method' => 'post', 'url' => '/account/login', 'id' => 'login-nav', 'class' => 'form')) }}
                                                <div class="form-group">
                                                    <label class="sr-only" for="headerLoginEmail">Email address</label>
                                                    <input type="email" name="email" class="form-control" id="headerLoginEmail" placeholder="Email address">
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="headerLoginPassword">Password</label>
                                                    <input type="password" name="password" class="form-control" id="headerLoginPassword" placeholder="Password">
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
                                    <a href="/auth/GitHub" class="btn btn-block btn-social btn-github"><i class="fa fa-github"></i> Sign in with GitHub</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="/account/dashboard">Dashboard</a></li>
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
                        PatchNotes is funded on <a class="gratipay-profile-link" target="_blank"><span class="gratipay-receiving">$0.00</span> / wk</a> via <a class="gratipay-link" target="_blank">Gratipay</a>.
                    </div>
                </div>
            </footer>

        </div><!-- /.container -->

        <script src="/assets/js/patchnotes.min.js"></script>
        @yield('scripts')

        <script src="//grtp.co/v1.js"></script>
    </body>

</html>
