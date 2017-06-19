<?php

function faker()
{
    return \Faker\Factory::create();
}

if (! function_exists('d')) {
    function d(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}
