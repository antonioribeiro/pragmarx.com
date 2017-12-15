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
                        <router-link to="/">
                            PragmaRX
                        </router-link>
                    </span>
                </div>

                <main-menu></main-menu>
            </nav>

            <div class="mt-6">
                <router-view></router-view>
            </div>
        </div>

        <script src="/js/app.js"></script>

        @include('templates.partials.livereload')
        @include('templates.partials.analytics')
    </body>
</html>
