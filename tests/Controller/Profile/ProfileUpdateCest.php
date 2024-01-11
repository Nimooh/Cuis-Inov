<?php


namespace App\Tests\Controller\Profile;

use App\Tests\Support\ControllerTester;

class ProfileUpdateCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile/update');
        $I->seeCurrentRouteIs('app_login');
    }
}
