<?php

namespace App\Services\Packages;

use Cache;
use App\Support\Constants;
use App\Data\Entities\Package;
use PragmaRX\Coollection\Package\Coollection;
use App\Services\GitHub\Service as GitHubService;
use App\Services\Packagist\Service as PackagistService;

class Service
{
    protected $response;

    /**
     * @var GitHubService
     */
    private $gitHub;

    /**
     * @var PackagistService
     */
    private $packagist;

    public function __construct(GitHubService $gitHub, PackagistService $packagist)
    {
        $this->gitHub = $gitHub;

        $this->packagist = $packagist;
    }

    /**
     * @return Coollection
     */
    private function excludablePackages()
    {
        return coollect([
            'pragmarx/googleforms',
            'pragmarx/ua-parser',
            'pragmarx/ci',
        ]);
    }

    /**
     * @param Coollection $packagist
     * @param Coollection $github
     * @return Coollection
     */
    private function mergeInfo($packagist, $github)
    {
        if (!is_null($info = Package::get($packagist['name'])))
        {
            $packagist = $packagist->merge($info);
        }

        $info = $github->merge($packagist);

        $info['keywords'] = $packagist->keywords->merge($github->keywords->toArray())->unique()->values();

        return $info;
    }

    public function makePackageTitle($package)
    {
        return studly(explode('/', $package['name'])[1]);
    }

    /**
     * @return Coollection
     */
    public function packages()
    {
        return Cache::remember(Constants::CACHE_PACKAGES_KEY, Constants::CACHE_PACKAGES_TIME, function() {
            return $this
                ->packagist->getPackagesFromPackagist()
                ->filter(function($package) {
                    return ! $this->excludablePackages()->contains($package);
                })
                ->mapWithKeys(function($package) {
                    $info = $this->packagist->getPackageInfoFromPackagist($package);

                    $info = $this->mergeInfo(
                        $info,
                        $this->gitHub->getPackageFromGitHub($this->gitHub->extractPackageName($info->repository))
                    );

                    $info = $this->normalizeKeywords($info);

                    if (!isset($info['title'])) {
                        $info['title'] = $this->makePackageTitle($info);
                    }

                    return [
                        $package => $info
                    ];
                })
                ->merge($this->gitHub->getPackagesFromGitHub())
                ->sortBy(
                    function ($package) {
                        return -coollect($package)->downloads->total;
                    }
                );
        });
    }


    /**
     * @param $info
     * @return mixed
     */
    function normalizeKeywords($info)
    {
        $info['keywords'] = coollect($info['keywords'])
            ->push($info['github_only'] === true
                ? 'repository'
                : 'package')
            ->map(function ($keyword) {
                return strtolower($keyword);
            })
            ->values()
            ->sort()
            ->values()
        ;

        return $info;
    }

    public function purgeCache()
    {
        Cache::forget(Constants::CACHE_PACKAGES_KEY);
    }
}
