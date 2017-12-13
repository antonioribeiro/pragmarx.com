<?php

namespace App\Services\Packagist;

use App\Services\GitHub\Service as GitHubService;
use Cache;
use GuzzleHttp\Client;
use App\Data\Entities\Package;
use Psr\Http\Message\StreamInterface;
use PragmaRX\Coollection\Package\Coollection;

class Service
{
    const PACKAGES_URL = 'https://packagist.org/packages/list.json?vendor=pragmarx';

    const PACKAGE_URL = 'https://packagist.org/packages/[vendor/package].json';

    protected $response;

    private $client;
    /**
     * @var GitHubService
     */
    private $gitHub;

    public function __construct(GitHubService $gitHub)
    {
        $this->gitHub = $gitHub;
    }

    /**
     * @param $key
     * @return Coollection
     */
    private function getPackageFromGitHub($key)
    {
        return $this->gitHub->repository($key);
    }

    protected function makePackageInfoFromPackagistPackage($package)
    {
        $package['github_url'] = $package['repository'];

        $package['packagist_url'] = str_replace('.json', '', $this->makePackageUrl($package['name']));

        $package['keywords'] = $package['versions']['dev-master']['keywords'];

        return $package;
    }

    private function excludablePackages()
    {
        return coollect([
            'pragmarx/googleforms',
            'pragmarx/ua-parser',
            'pragmarx/ci',
        ]);
    }

    /**
     * @return Client
     */
    private function httpClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param $url
     * @return Coollection|null
     */
    public function httpGet($url)
    {
        $this->response = $this->httpClient()->request('GET', $url);;

        return $this->response->getStatusCode() === 200
            ? $this->responseToCollection($this->response->getBody())
            : null;
    }

    /**
     * @return Coollection
     */
    public function getPackagesFromPackagist()
    {
        return Cache::remember('packagist-packages', 300, function () {
            return coollect(
                $this->httpGet(static::PACKAGES_URL)->packageNames
            );
        });
    }

    /**
     * @return Coollection
     */
    public function getPackagesFromGitHub()
    {
        Cache::remember('github-packages', 300, function () {
            return Package::fromGitHub()->map(function($package, $key) {
                return $package->merge($this->makePackageInfoFromGithubPackage($this->getPackageFromGitHub($key)));
            });
        });
    }

    protected function makePackageInfoFromGithubPackage($package)
    {
        return [
            'name' => $package->full_name,
            'description' => $package->description,
            'downloads' => [
                'total' => -1,
                'monthly' => -1,
                'daily' => -1,
            ],
            'github_stars' => $package->stargazers_count,
            'keywords' => $package->topics,
        ];
    }

    /**
     * @param $package
     * @return mixed
     */
    private function makePackageUrl($package)
    {
        return str_replace('[vendor/package]', $package, static::PACKAGE_URL);
    }

    private function mergeInfo($packageInfo)
    {
        if (!is_null($info = Package::get($packageInfo['name'])))
        {
            $packageInfo = array_merge($packageInfo->toArray(), $info);
        }

        return coollect($packageInfo);
    }

    /**
     * @param $package
     * @return static
     */
    public function getPackageInfoFromPackagist($package)
    {
        return Cache::remember("packagist-$package", 300, function() use ($package) {
            $package = coollect($this->httpGet($this->makePackageUrl($package))->package)
                ->only('name', 'description', 'repository', 'downloads', 'github_stars', 'versions');

            return $this->makePackageInfoFromPackagistPackage($package);
        });
    }

    /**
     * @return Coollection
     */
    public function packages()
    {
        return $this
            ->getPackagesFromPackagist()
            ->filter(function($package) {
                return ! $this->excludablePackages()->contains($package);
            })
            ->mapWithKeys(function($package) {
                $info = $this->mergeInfo($this->getPackageInfoFromPackagist($package));

                if (!isset($info['title'])) {
                    $info['title'] = $this->makePackageTitle($info);
                }

                return [
                    $package => $info
                ];
            })
            ->merge($this->getPackagesFromGitHub())
            ->sortBy(
                function ($package) {
                    return -coollect($package)->downloads->total;
                }
            );
    }

    public function makePackageTitle($package)
    {
        return studly(explode('/', $package['name'])[1]);
    }

    /**
     * @param StreamInterface $response
     * @return Coollection
     */
    private function responseToCollection(StreamInterface $response)
    {
        return is_array($array = json_decode((string) $response, true))
            ? coollect($array)
            : null;
    }

    /**
     * @return Coollection|\Tightenco\Collect\Support\Collection
     */
    public function summary()
    {
        return coollect([
            'downloads' => $this->packages()->reduce(function ($carry, $package) {
                return $carry + $package->downloads->total;
            }, 0),

            'stars' => $this->packages()->reduce(function ($carry, $package) {
                return $carry + $package['github_stars'];
            }, 0),
        ]);
    }
}
