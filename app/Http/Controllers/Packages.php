<?php

namespace App\Http\Controllers;

use App\Services\Packagist;

class Packages extends Controller
{
    /**
     * @var Packagist
     */
    private $packagist;

    public function __construct(Packagist $packagist)
    {
        $this->packagist = $packagist;
    }

    public function all()
    {
        return [
            'packages' => $this->packagist->packages()->toArray(),
            'summary' => $this->packagist->summary()->toArray(),
        ];
    }
}
