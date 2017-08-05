<?php

use Symfony\Component\Console\Command\Command;

require __DIR__.'/vendor/autoload.php';

ListOldKernels::__list();

class ListOldKernels extends Command
{
    public static function __list()
    {
        (new static())->listOldPackages();
    }

    private function listOldPackages()
    {

    }
}
