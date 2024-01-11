<?php


namespace App\Tests\Controller\Profile;

use App\Tests\Support\ControllerTester;

class ProfileDeleteCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile/delete');
        $I->seeCurrentRouteIs('app_login');
    }
}
