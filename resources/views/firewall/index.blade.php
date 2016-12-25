@extends('templates.main')

@section('content')
    <h1><a href="Firewall Package">Firewall Package</a></h1>

    <h2>Your IP Address</h2>
    <p class="monospace green"><strong>{{ $user_ip }}</strong></p>
    <a href="/firewall/blacklist/{{ $user_ip }}" class="btn btn-danger">blacklist</a>
    <a href="/firewall/whitelist/{{ $user_ip }}" class="btn btn-success">whitelist</a>
    <a href="/firewall/remove/{{ $user_ip }}" class="btn btn-warning">remove</a>

    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
            @if($whitelist->count())
                <h2>Whitelisted</h2>
                @foreach($whitelist as $item)
                    <p class="monospace green"><strong>{{ $item->ip_address }}</strong></p>
                @endforeach
            @endif
        </div>
        <div class="col-md-4">
            @if($blacklist->count())
                <h2>Blacklisted</h2>
                @foreach($blacklist as $item)
                    <p class="monospace red"><strong>{{ $item->ip_address }}</strong></p>
                @endforeach
            @endif
        </div>
    </div>


    <h2>Firewall testing links</h2>
    <h4>
        <p><a href="/firewall/blocked">Blacklist Protected: you only have access to this route if your IP is NOT BLACKLISTED.</a></p>
        <p><a href="/firewall/whitelisted">Whitelist Enforced: you only have access to this route if your IP IS WHITELISTED.</a></p>
        <p><a href="/firewall/normal">Unproteced: anyone has access to this route.</a></p>
    </h4>
@stop
