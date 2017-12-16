<?php

namespace App\Services\Packagist;

use Github\Exception\RuntimeException;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;
use PragmaRX\Coollection\Package\Coollection;
use App\Services\GitHub\Service as GitHubService;

class Service
{
    const PACKAGES_URL = 'https://packagist.org/packages/list.json?vendor=';

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

        $package['version'] = collect($package['versions'])->keys()->filter(function($version) {
            return starts_with($version, 'v');
        })->values()->sortBy(function($a) {
            return -$this->makeSortableVersion($a);
        })->first();

        unset($package['versions']);

        return $package;
    }

    /**
     * @param string $vendor
     * @return string
     */
    protected function makeListPackagesUrl($vendor)
    {
        return static::PACKAGES_URL.$vendor;
    }

    public function makeSortableVersion($a)
    {
        preg_match('/v(\d)\.(\d)\.(\d)/', $a, $matches);

        if (count($matches) == 4) {
            return ((int) $matches[1])*1000 + ((int) $matches[2])*100 + ((int) $matches[3])*10;
        }

        return null;
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
        try {
            $this->response = $this->httpClient()->request('GET', $url);;

            return $this->response->getStatusCode() === 200
                ? $this->responseToCollection($this->response->getBody())
                : null;
        } catch (\Exception $exception) {
            return coollect([
                'url' => $url,
                'error' => true,
                'error_message' => $exception->getMessage(),
                'exception' => $exception
            ]);
        }
    }

    /**
     * @param string $vendor
     * @return Coollection
     */
    public function getPackagesFromPackagist($vendor)
    {
        return coollect(
            $this->httpGet($this->makeListPackagesUrl($vendor))->packageNames
        );
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
