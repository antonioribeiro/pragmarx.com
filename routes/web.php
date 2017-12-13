<?php

use PragmaRX\Countries\Package\Support\UpdateData;

Route::group(['middleware' => 'firewall'], function () {
    Route::get('/', 'Home@index');
});

Route::get('/carbon', function () {
    $before = Carbon\Carbon::now();

    sleep(3);

    $now = Carbon\Carbon::now();

    return $now->diffInSeconds($before); // returns 0
});

Route::get('/carbon-real', function () {
    $before = Carbon\Carbon::now();

    sleep(3);

    Carbon\Carbon::setTestNow(null);

    return Carbon\Carbon::now()->diffInSeconds($before); // returns 0
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('/packages', 'Packages@all');
});

require base_path('routes/firewall.php');
require base_path('routes/google2fa.php');

Route::get('/countries', function () {

//    app(UpdateData::class)->updateAdminStates();

    dd("Countries::where('name.common', 'Brazil')", Countries::where('name.common', 'Brazil'));

//
//    dump("Countries::where('name.native.por.common', 'Brasil')", Countries::where('name.native.por.common', 'Brasil'));
//
//    dump("Countries::where('tld.0', '.ch')", Countries::where('tld.0', '.ch'));

//    $state = Countries::where('cca3', 'USA')->first();
//
//    $state = $state->states;

//    dump("Countries::where('cca3', 'USA')->first()->states->pluck('name', 'postal')", dump(Countries::where('cca3', 'USA')->first())->states->pluck('name', 'postal'));

//    dump("Countries::where('cca3', 'FRA')
//         ->first()
//         ->borders
//         ->first()
//         ->name
//         ->official", Countries::where('cca3', 'FRA')
//                               ->first()
//        ->borders
//        ->first()
//        ->name
//        ->official);


});
