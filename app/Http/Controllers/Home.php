<?php

namespace App\Http\Controllers;

use App\Services\Packagist;

class Home extends Controller
{
    /**
     * @var Packagist
     */
    private $packagist;

    public function __construct(Packagist $packagist)
    {
        $this->packagist = $packagist;
    }

    public function index()
    {
        return view('home.index');
    }
}
