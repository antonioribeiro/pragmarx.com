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
    dd(new FirewallTestCase);
})->describe('');
