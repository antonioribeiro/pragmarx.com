<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="/css/app.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
    </head>

    <body class="bg-grey-light">
        @yield('page-contents')

        @include('templates.partials.livereload')
        @include('templates.partials.analytics')
    </body>
</html>
