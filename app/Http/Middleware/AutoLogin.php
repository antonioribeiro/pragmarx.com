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

            /// &&& ------------- remove this

            $user->name = 'Boris Jacobi';

            $user->email = 'destini24@mraz.com';

            $user->company = 'Wiegand-Hintz';

            $user->google2fa_secret = '6HGIRZU5M7QDY3N723HEA76N2MB7OK4J';

            $user->qrcode_url = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth%3A%2F%2Ftotp%2FWiegand-Hintz%3Adestini24%2540mraz.com%3Fsecret%3D6HGIRZU5M7QDY3N723HEA76N2MB7OK4J%26issuer%3DWiegand-Hintz';

            session()->put('currentUser', $user);
        }

        $this->auth->login($user);

        return $next($request);
    }
}
