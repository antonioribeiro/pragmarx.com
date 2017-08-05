<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class StreamAConTest extends DuskTestCase
{
    public function testEmailAddressNotFoundAtStreamACon()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://streamacon.com/password/reset')
                    ->waitForText('RESET YOUR PASSWORD')
                    ->type('email', 'acr+picatic@antoniocarlosribeiro.com')
                    ->press('SEND PASSWORD RESET LINK')
                    ->assertDontSee("We can't find a user with that e-mail address.");
        });
    }
}

