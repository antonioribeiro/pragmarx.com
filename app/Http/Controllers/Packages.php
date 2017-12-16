<?php

namespace App\Http\Controllers;

use App\Services\Packages\Service as PackagesService;
use Illuminate\Http\Request;

class Packages extends Controller
{
    /**
     * @var PackagesService
     */
    private $packages;

    public function __construct(PackagesService $packages)
    {
        $this->packages = $packages;
    }

    public function all($vendor = null, Request $request)
    {
        if ($request->get('force')) {
            $this->packages->purgeCache();
        }

        return $this->packages->packages($vendor)->toArray();
    }
}
