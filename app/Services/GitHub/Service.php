<?php

namespace App\Services\GitHub;

use Cache;
use App\Data\Entities\Package;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Container\Container;
use PragmaRX\Coollection\Package\Coollection;

class Service
{
    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->mutateFactory();
    }

    public function extractPackageName($repository)
    {
        $parts = explode('/', $repository);

        return "{$parts[3]}/{$parts[4]}";
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
        try {
            list($vendor, $name) = explode('/', $name);

            return coollect(
                Github::repo()->show($vendor, $name, [], ['Accept' => 'application/vnd.github.mercy-preview+json'])
            );
        } catch (\Exception $exception) {
            return coollect([
                'name' => $name,
                'error' => true,
                'error_message' => $exception->getMessage(),
                'exception' => $exception
            ]);
        }
    }

    /**
     * @param $package
     * @return Coollection
     */
    protected function makePackageInfoFromGithubPackage($package)
    {
        if (isset($package['error'])) {
            return $package;
        }

        return coollect([
            'name' => $package->full_name,
            'description' => $package->description,
            'downloads' => [
                'total' => -1,
                'monthly' => -1,
                'daily' => -1,
            ],
            'github_stars' => $package->stargazers_count,
            'keywords' => $package->topics,
            'github_url' => $package->html_url,
        ]);
    }

    /**
     * @return Coollection
     */
    public function getPackagesFromGitHub($vendor)
    {
        if ($vendor !== 'pragmarx') {
            return coollect();
        }

        return Package::fromGitHub()->map(function($package, $key) use ($vendor) {
            return $package->merge($this->getPackageFromGitHub($key, $vendor));
        });
    }

    /**
     * @param $key
     * @return Coollection
     */
    public function getPackageFromGitHub($key)
    {
        return $this->makePackageInfoFromGithubPackage($this->repository($key));
    }
}
