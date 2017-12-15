<?php

namespace App\Services\Packagist;

use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;
use PragmaRX\Coollection\Package\Coollection;
use App\Services\GitHub\Service as GitHubService;

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

    protected function makePackageInfoFromPackagistPackage($package)
    {
        $package['github_only'] = false;

        $package['github_url'] = $package['repository'];

        $package['packagist_url'] = str_replace('.json', '', $this->makePackageUrl($package['name']));

        $package['keywords'] = $package['versions']['dev-master']['keywords'];

        unset($package['versions']);

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
        return coollect(
            $this->httpGet(static::PACKAGES_URL)->packageNames
        );
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

    /**
     * @param $package
     * @return Coollection
     */
    public function getPackageInfoFromPackagist($package)
    {
        return $this->makePackageInfoFromPackagistPackage(
            coollect($this->httpGet($this->makePackageUrl($package))->package)
                ->only('name', 'description', 'repository', 'downloads', 'versions')
        );
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
