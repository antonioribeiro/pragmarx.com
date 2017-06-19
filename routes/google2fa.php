<?php

use ParagonIE\ConstantTime\Base32;
use PragmaRX\Google2FALaravel\Authenticator;

Route::group(['prefix' => '/google2fa', 'middleware' => 'autologin'], function () {
    Route::get('/', function () {
        return view('google2fa.playground');
    });

    Route::get('/middleware', function () {
        return view('google2fa.passed');
    })->middleware('2fa');

    Route::get('/middleware/logout', function () {
        (new Authenticator(request()))->logout();

        session()->forget('currentUser');

        return redirect()->to('/google2fa/middleware');
    });

    Route::post('/middleware/authenticate', function () {
        return redirect()->to('/google2fa/middleware');
    })->middleware('2fa');
});

Route::group(['prefix' => '/api/v1/google2fa'], function () {
    Route::get('/email', function () {
        return ['email' => Faker\Factory::create()->email];
    });

    Route::get('/company', function () {
        return ['company' => Faker\Factory::create()->company];
    });

    Route::get('/secret-key/{prefix}', function ($prefix) {
        $power = 1;

        while (pow(2, $power) < (int) ((strlen($prefix) * 8 + 4) / 5)) {
            $power++;
        }

        try {
            return ['secretKey' => Google2FA::generateSecretKey(pow(2, $power), $prefix)];
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    });

    Route::get('/secret-key-prefix', function () {
        return [
            'secretKeyPrefix' => $prefix = str_random(20),
            'secretKeyPrefixB32' => Base32::encodeUpper($prefix),
        ];
    });

    Route::get('/qr-code-url/{company}/{email}/{secretKey}', function ($company, $email, $secretKey) {
        $google2fa_url = Google2FA::getQRCodeGoogleUrl(
            $company,
            $email,
            $secretKey
        );

        return ['url' => $google2fa_url];
    });

    Route::post('/check-password', function () {
        function verifyPassword($password = null, $timestamp = true)
        {
            if ($timestamp === true) {
                $valid = Google2FA::verifyKey(
                    request()->get('secretKey'),
                    $password ?: request()->get('password'),
                    request()->get('window')
                );
            } else {
                $valid = Google2FA::verifyKeyNewer(
                    request()->get('secretKey'),
                    $password ?: request()->get('password'),
                    $timestamp,
                    request()->get('window')
                );
            }

            return $valid;
        }

        function passwordIsInList($find, $passwordList)
        {
            if (is_array($passwordList)) {
                foreach ($passwordList as $password) {
                    if ($password['password'] == $find) {
                        return true;
                    }
                }
            }

            return false;
        }

        function gexMaxTimestamp($passwordList)
        {
            return collect($passwordList)->max('timestamp');
        }

        try {
            $password = request()->get('password');

            $passwordList = request()->get('passwordList');

            if ((! empty($password)) && (verifyPassword($password)) && ! passwordIsInList($password, $passwordList)) {
                array_unshift($passwordList, ['password' => $password, 'isValid' => true, 'timestamp' => Google2FA::getTimestamp()]);
            }

            foreach ($passwordList as $key => $item) {
                $passwordList[$key]['isValid'] = verifyPassword($item['password']) !== false;
                $passwordList[$key]['isValidAfterTimestamp'] = verifyPassword($item['password'], gexMaxTimestamp($passwordList)) !== false;
                $passwordList[$key]['isValidAfterTimestamp2'] = Google2FA::verifyKey(
                    request()->get('secretKey'),
                    $item['password'],
                    request()->get('window'),
                    gexMaxTimestamp($passwordList)
                );
                $passwordList[$key]['maxTimestamp'] = gexMaxTimestamp($passwordList);
            }

            $passwordList = array_slice($passwordList, 0, 8);
        } catch (\Exception $exception) {
            /// do nothing
        }

        return [
            'passwordList' => $passwordList,
            'currentTimestamp' => Google2FA::getTimestamp(),
        ];
    });
});
