<?php

namespace App\Data\Entities;

use PragmaRX\Coollection\Package\Coollection;

class Package
{
    public static function all()
    {
        return coollect([
            'pragmarx/tddd' => [
                'title' => 'TDDD',
            ],

            'pragmarx/laravelcs' => [
                'title' => 'LaravelCS',
            ],

            'pragmarx/google2fa' => [
                'title' => 'Google2FA',
            ],

            'pragmarx/google2fa-laravel' => [
                'title' => 'Google2FA Laravel',
            ],

            'pragmarx/version' => [
                'title' => 'Version',
            ],

            'pragmarx/sqli' => [
                'title' => 'sqli',
            ],

            'antonioribeiro/tddd-starter' => [
                'github_only' => true,
                'title' => 'TDDD Starter',
            ],

            'antonioribeiro/pragmarx.com' => [
                'github_only' => true,
                'title' => 'pragmarx.com',
                'website' => 'https://pragmarx.com',
            ],

            'antonioribeiro/acr.com' => [
                'github_only' => true,
                'title' => 'antoniocarlosribeiro.com',
                'website' => 'https://antoniocarlosribeiro.com',
            ],

            'antonioribeiro/dev-box' => [
                'github_only' => true,
                'title' => 'dev-box',
            ],

            'antonioribeiro/artisan-anywhere' => [
                'github_only' => true,
                'title' => 'Artisan Anywhere',
            ],

            'antonioribeiro/glottosAdmin' => [
                'github_only' => true,
                'title' => 'Glottos Admin Panel',
            ],

            'antonioribeiro/skel' => [
                'github_only' => true,
                'title' => 'skel',
            ],

        ]);
    }

    /**
     * @param string $name
     * @return null|Coollection
     */
    public static function get($name)
    {
        if (static::all()->has($name)) {
            return static::all()[$name];
        }

        return null;
    }

    /**
     * @return Coollection
     */
    public static function fromGitHub()
    {
        return static::all()->where('github_only', true);
    }
}
