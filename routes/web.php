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

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('/repositories/{vendor?}', 'Packages@all');
});

require base_path('routes/firewall.php');
require base_path('routes/google2fa.php');

Route::get('/countries', function () {

    // dd(Countries::where('name.common', 'Brazil')->hydrateTimezone());

//    app(UpdateData::class)->updateAdminStates();

//    dd("Countries::where('name.common', 'Brazil')", Countries::where('name.common', 'Brazil'));
//
//    dd("Countries::where('name.native.por.common', 'Brasil')", Countries::where('name.native.por.common', 'Brasil'));
//
//    dd("Countries::where('tld.0', '.ch')", Countries::where('tld.0', '.ch'));
//
//    $state = Countries::where('cca3', 'USA')->first();
//
//    dd($state = $state->states);

//    dd("Countries::where('cca3', 'USA')->first()->states->pluck('name', 'postal')", dump(Countries::where('cca3', 'USA')->first())->states->pluck('name', 'postal'));

//    dump(Countries::where('cca3', 'PSE')
//                  ->first()
//                  ->hydrate('states'));

//    dump(Countries::where('cca3', 'ITA')
//                  ->first()
//                  ->hydrate('states')->states['TP']);
//
//    dump(Countries::where('cca3', 'BRA')
//                ->first()
//                ->hydrate('timezone'));

    dump(
        Countries::where('cca3', 'BRA')->first()->hydrateCities()
    );

    dd('done');
});
