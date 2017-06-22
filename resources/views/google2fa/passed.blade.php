@extends('templates.main')

@section('content')
    <div id="vue-google2fa">
        <h1><a href="https://github.com/antonioribeiro/google2fa">One Time Password</a></h1>

        <h2>Contratulations, your 'One Time Password' was correct and you have successfully logged in!</h2>

        <br><br><br><br>

        <a href="/google2fa/middleware/logout" class="btn btn-primary">Logout</a>

        <br><br><br>
        <h5>
            @if (config('google2fa.lifetime') === 0)
                This 2FA login session should last forever.
            @else
                You should be logged off automatically at {{ $nextReload = session()->get('google2fa.auth_time')->addMinutes(config('google2fa.lifetime'))->format('H:i:s') }}
            @endif
        </h5>

        <br><br><br>

        <h3 id="clock"></h3>
    </div>

    <script>
        var currentTime;

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            currentTime = document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
            reload();
        }

        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        function reload() {
            if (currentTime > '{{ $nextReload }}') {
                location.reload();
            }
        }

        startTime();
    </script>
@stop
