@extends('templates.main')

@section('content')
    <div id="vue-google2fa">
        <h1><a href="https://github.com/antonioribeiro/google2fa">One Time Password</a></h1>

        <h2>Contratulations, your 'One Time Password' was correct and you have successfully logged in!</h2>

        <br><br><br><br>

        <a href="/google2fa/middleware/logout" class="btn btn-primary">Logout</a>
    </div>
@stop
