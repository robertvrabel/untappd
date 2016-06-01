<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Untappd Reports</title>

    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-78646107-1', 'auto');
    ga('send', 'pageview');

</script>
<div class="top-bar">
    <div class="row">
        <div class="small-12 columns">
            <div class="top-bar-left">
                <ul class="menu">
                    <li class="menu-text"><a href="/">Untappd Reports</a></li>
                    <li><a href="{{ route('firstcheckin.index') }}">First Checkin</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        @include('flash::message')
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="small-12 columns">
            @yield('content')
        </div>
    </div>
</div>

<!-- Scripts -->
@if (getenv('APP_ENV') == 'local')
    <script src="/js/jquery.min.js"></script>
    <script src="/js/foundation.min.js"></script>
@else
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/6.2.0/foundation.min.js"></script>
@endif

@yield('footer')
<script src="{{ elixir('js/main.js') }}"></script>

</body>
</html>