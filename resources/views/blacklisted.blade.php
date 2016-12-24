@extends('templates.main')

@section('content')
    <div class="title">PragmaRX</div>
    <h2><a href="Firewall Package">Firewall Package</a></h2>

    @if($whitelist->count())
        <h3>Whitelisted</h3>
        @foreach($whitelist as $item)
            {{ $item['ip_address'] }}
        @endforeach
    @endif

    @if($blacklist->count())
        <h3>Blacklisted</h3>
        @foreach($blacklist as $item)
            {{ $item['ip_address'] }}
        @endforeach
    @endif

    <h4>
        <p><a href="/firewall/blocked">Blocked Route</a></p>
    </h4>
@stop
