<?php

use PragmaRX\Firewall\Tests\TestBench\FirewallTestCase;

Artisan::command('health:server-clean {--run} {--protect=}', function () {
    app(\App\Support\ServerCleaner::class)
        ->setCommand($this)
        ->setRun($this->options()['run'])
        ->setProtect($this->options()['protect'])
        ->clean();
})->describe('');

Artisan::command('test', function () {

//    dd(load_shapefile('/Users/antoniocarlos/code/pragmarx/pragmarx.com/vendor/pragmarx/countries/src/data/ne_10m_admin_0_boundary_lines_land/ne_10m_admin_0_boundary_lines_land'));
    $records = load_shapefile('/Users/antoniocarlos/code/pragmarx/pragmarx.com/vendor/pragmarx/countries/src/data/natural-earth-vector/10m_cultural/ne_10m_admin_0_countries');
//    $records = load_shapefile('/Users/antoniocarlos/code/pragmarx/pragmarx.com/vendor/pragmarx/countries/src/data/natural-earth-vector/110m_cultural/ne_110m_populated_places');
//    $records = load_shapefile('/Users/antoniocarlos/code/pragmarx/pragmarx.com/vendor/pragmarx/countries/src/data/chile-latest-free.shp/gis.osm_landuse_a_free_1');
//    $records = load_shapefile('/Users/antoniocarlos/code/pragmarx/pragmarx.com/vendor/pragmarx/countries/src/data/chile-latest-free.shp/gis.osm_places_free_1');

    foreach (range(0,10) as $record) {
        dump($records[$record]);
    }

    dd(count($records));
    file_put_contents('populated_places.txt', json_encode($records));

})->describe('');

Artisan::command('bench', function () {

    foreach (range(1, 1000) as $counter) {
        Countries::loadCountries();
    }

})->describe('');
