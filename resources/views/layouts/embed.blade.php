<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Project Embed</title>

        @yield('head')

        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
        <link href="{{ elixir("css/app.css") }}" rel="stylesheet">

        @if(!empty(Config::get('patchnotes.tracking.ga.code')))
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', '{{ Config::get('patchnotes.tracking.ga.code') }}', 'auto');
                ga('require', 'linkid', 'linkid.js');
                ga('send', 'pageview');

                @if(Sentry::check())
                ga('set', '&uid', {{ Sentry::getUser()->id }});
                @endif
            </script>
        @endif
    </head>

    <body>

        <div id="content" class="container">
            @yield('content')
        </div>


        <script src="{{ elixir("js/app.js") }}"></script>
        @yield('scripts')
    </body>
</html>
