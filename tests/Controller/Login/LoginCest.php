<?php

namespace App\Tests\Controller\Login;

use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function pageLoadingCorrectly(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Log in!');
    }
}
