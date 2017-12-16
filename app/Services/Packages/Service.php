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

        if ($github->count() > 0 and isset($github['keywords'])) {
            $info['keywords'] = $info->keywords->merge($github->keywords->toArray())->unique()->values();
        }

        return $info;
    }

    public function makePackageTitle($package)
    {
        return studly(explode('/', $package['name'])[1]);
    }

    /**
     * Load all packages for a vendor.
     *
     * @param string|null $vendor
     * @return Coollection
     */
    public function packages($vendor = null)
    {
        $vendor = is_null($vendor) ? 'pragmarx' : $vendor;

        return Cache::remember(Constants::CACHE_PACKAGES_KEY."-$vendor", Constants::CACHE_PACKAGES_TIME, function() use ($vendor) {
            return $this
                ->packagist->getPackagesFromPackagist($vendor)
                ->filter(function($package) {
                    return ! $this->excludablePackages()->contains($package);
                })
                ->mapWithKeys(function($package) use ($vendor) {
                    $info = $this->packagist->getPackageInfoFromPackagist($package);

                    $info = $this->mergeInfo(
                        $info,
                        $this->gitHub->getPackageFromGitHub($this->gitHub->extractPackageName($info->repository), $vendor)
                    );

                    $info = $this->normalizeKeywords($info);

                    if (!isset($info['title'])) {
                        $info['title'] = $this->makePackageTitle($info);
                    }

                    return [
                        $package => $info
                    ];
                })
                ->merge($this->gitHub->getPackagesFromGitHub($vendor))
                ->reject(function ($package) {
                    return isset($package['error']);
                })
                ->sortBy(function ($package) {
                    return - (coollect($package)->downloads->total * coollect($package)->github_stars);
                });
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
