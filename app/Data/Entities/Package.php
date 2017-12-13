<?php

namespace App\Data\Entities;

class Package
{
    public static function all()
    {
        return coollect([
            'pragmarx/version' => [
                'title' => 'Version',
            ],

            'antonioribeiro/tddd-starter' => [
                'github_only' => true,
                'title' => 'TDDD Starter',
            ],
        ]);
    }

    public static function get($name)
    {
        if (static::all()->has($name)) {
            return static::all()[$name];
        }

        return null;
    }

    public static function fromGitHub()
    {
        return static::all()->where('github_only', true);
    }
}
