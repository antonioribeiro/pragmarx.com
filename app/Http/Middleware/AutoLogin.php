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

            $user->name = env('AUTOLOGIN_NAME', faker()->name);

            $user->email = env('AUTOLOGIN_EMAIL', faker()->email);

            $user->company = env('AUTOLOGIN_COMPANY', faker()->company);

            $user->google2fa_secret = env('AUTOLOGIN_SECRET', Google2FA::generateSecretKey(32));

            $user->qrcode_url = env('AUTOLOGIN_QRCODE_URL', Google2FA::getQRCodeGoogleUrl($user->company, $user->email, $user->google2fa_secret));

            session()->put('currentUser', $user);
        }

        $this->auth->login($user);


        return $next($request);
    }
}
