<?php


namespace App\Tests\Controller\Profile;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile');
        $I->seeCurrentRouteIs('app_login');
    }
}
