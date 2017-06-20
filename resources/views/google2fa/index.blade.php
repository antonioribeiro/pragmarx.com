@extends('templates.main')

@section('content')
    <div id="vue-google2fa">
        <h1><a href="https://github.com/antonioribeiro/google2fa">One Time Password</a></h1>
        <h4>Middleware Demo</h4>

        <p class="large">Please open Google Authenticator and type a password below</p>

        <br><br>

        @foreach ($errors->all() as $error)
            <p class="text-danger">
                {{ $error }}
            </p>
        @endforeach

        <form action="/google2fa/middleware/authenticate" method="POST">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input name="one_time_password" type="text" class="form-control" placeholder="One Time Password">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Authenticate</button>
                    </div>
                </div>
            </div>
        </form>

        <br><br>
        <p>{{ ($user = Auth::user())->name }} ({{ $user->company }})</p>
        <p>{{ $user->email }}</p>
        <p>{{ $user->google2fa_secret }}</p>
        <p><img src="{{ $user->qrcode_url }}" alt=""></p>
    </div>
@stop
