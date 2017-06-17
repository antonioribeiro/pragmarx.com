
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>PragmRX</title>

        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet"
              type="text/css">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css"
              integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi"
              crossorigin="anonymous">

        <link rel="stylesheet" href="/css/app.css">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'apiPrefix' => '/api/v1',
            ]) !!};
        </script>
    </head>

    <body>
        <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
            <a class="navbar-brand" href="/">PragmaRX</a>
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/firewall">Firewall Test Page</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/google2fa">Google2FA Test Page</a>
                </li>
            </ul>
        </nav>

        <div class="container">
            <div class="starter-template">
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="content">
                                @yield('content')
                            </div>
                        </div>
                    </div>

                    @include('githubRibbon')
                </body>
            </div>
        </div><!-- /.container -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"
                integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK"
                crossorigin="anonymous">
        </script>

        <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>

        <script src="/js/app.js"></script>

        @if(config('app.env') == 'local')
            <script src="http://localhost:35729/livereload.js"></script>
        @endif
    </body>
</html>
