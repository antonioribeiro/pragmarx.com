<?php

Artisan::command('health:server-clean {--run} {--protect=}', function () {
    app(\PragmaRX\Health\Support\ServerCleaner::class)
        ->setCommand($this)
        ->setRun($this->options()['run'])
        ->setProtect($this->options()['protect'])
        ->clean();
})->describe('');
