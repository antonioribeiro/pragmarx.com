<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>PragmRX</title>

        <link rel="stylesheet" href="/css/app.css">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'apiPrefix' => '/api/v1',
            ]) !!};
        </script>

        <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
    </head>

    <body class="bg-grey-light">
        <div id="vue-root">
            <nav class="flex items-center justify-between flex-wrap bg-red-dark p-6">
                <div class="flex items-center flex-no-shrink text-white mr-6">
                    <span class="text-3xl tracking-tight">
                        <a href="/">PragmaRX</a>
                    </span>
                </div>

                <main-menu></main-menu>
            </nav>

            <div class="mt-6">
                <router-view></router-view>
            </div>
        </div>

        <script src="/js/app.js"></script>

        @if(config('app.env') == 'local')
            <script src="http://localhost:35729/livereload.js"></script>
        @endif

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-46685774-6', 'auto');
            ga('send', 'pageview');
        </script>
    </body>
</html>
