<?php

namespace Tests\Browser;

use Google2FA;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class Google2FATest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testCode()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/google2fa/middleware')
                    ->waitForText('Middleware Demo')
                    ->type('one_time_password', Google2FA::getCurrentOtp(env('GOOGLE2FA_TEST_SECRET')))
                    ->press('Authenticate')
                    ->waitForText("your 'One Time Password' was correct")
            ;
        });
    }
}
