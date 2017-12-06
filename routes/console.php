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
    collect([1, 3])->dump(5);

    echo "------------------------------------------\n";

    collect([1, 3])->dd(5);
})->describe('');
