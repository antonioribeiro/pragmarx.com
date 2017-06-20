<?php

namespace App\Http\Middleware;

use Closure;
use Google2FA;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class AutoLogin extends BaseVerifier
{
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (is_null($user = session()->get('currentUser'))) {
            $user = new \App\Data\Entities\User();

            $user->name = faker()->name;

            $user->email = faker()->email;

            $user->company = faker()->company;

            $user->google2fa_secret = Google2FA::generateSecretKey(32);

            $user->qrcode_url = Google2FA::getQRCodeGoogleUrl($user->company, $user->email, $user->google2fa_secret);

            session()->put('currentUser', $user);
        }

        $this->auth->login($user);


        return $next($request);
    }
}
