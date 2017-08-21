<?php

Route::group(['prefix' => '/firewall', 'middleware' => 'fw-block-attacks'], function () {
    Route::get('/', function () {
        $user_ip = Firewall::getIp();

        $blacklist = Firewall::all()->filter(function ($item) {
            return $item->whitelisted == false;
        });

        $whitelist = Firewall::all()->filter(function ($item) {
            return $item->whitelisted == true;
        });

        return view('firewall.index', compact('blacklist', 'whitelist', 'user_ip'));
    });

    Route::get('/forbidden', function () {
        return view('firewall.forbidden');
    });

    Route::get('/blacklist/{ip}', function ($ip) {
        Firewall::blacklistOnSession($ip);

        return redirect()->to('/firewall');
    });

    Route::get('/whitelist/{ip}', function ($ip) {
        Firewall::whitelistOnSession($ip);

        return redirect()->to('/firewall');
    });

    Route::get('/remove/{ip}', function ($ip) {
        Firewall::removeFromSession($ip);

        return redirect()->to('/firewall');
    });

    /// Those routes are blocked
    Route::group(['middleware' => 'fw-block-bl'], function () {
        Route::get('/blocked', function () {
            return view('firewall.yay');
        });
    });

    /// Those routes are blocked
    Route::group(['middleware' => 'fw-allow-wl'], function () {
        Route::get('/whitelisted', function () {
            return view('firewall.yay');
        });
    });

    Route::get('/normal', function () {
        return view('firewall.yay');
    });
});
