<?php

namespace App\Services\GitHub;

use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Container\Container;

class Service
{
    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->mutateFactory();
    }

    /**
     * Register the github factory class.
     *
     * @return void
     */
    protected function mutateFactory()
    {
        app()->singleton('github.factory', function (Container $app) {
            $auth = $app['github.authfactory'];

            $cache = $app['cache'];

            return new GitHubFactory($auth, $cache);
        });
    }

    /**
     * @param $name
     * @return \PragmaRX\Coollection\Package\Coollection
     */
    public function repository($name)
    {
        list($vendor, $name) = explode('/', $name);

        return coollect(
            Github::repo()->show($vendor, $name, [], ['Accept' => 'application/vnd.github.mercy-preview+json'])
        );
    }
}
