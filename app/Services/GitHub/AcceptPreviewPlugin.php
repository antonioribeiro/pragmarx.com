<?php

namespace App\Services\GitHub;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

class AcceptPreviewPlugin implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $request->withHeader('Accept', 'application/vnd.github.mercy-preview+json');

        return $next($request);
    }
}
