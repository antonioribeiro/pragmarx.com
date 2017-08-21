<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'firewall'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

require base_path('routes/firewall.php');
require base_path('routes/google2fa.php');
