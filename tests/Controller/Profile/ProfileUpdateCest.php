<?php


namespace App\Tests\Controller\Profile;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;

class ProfileUpdateCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile/update');
        $I->seeCurrentRouteIs('app_login');
    }
    public function isFormLoaded(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile/update');
        $I->seeInTitle("Edition de ".$membre->getPrnmMembre()." ".$membre->getNomMembre());
        $I->see("Mon Profil", 'h1');
        $I->see("Mes Allergènes", 'h1');
        $I->assertEquals($I->grabValueFrom('#profile_email'), $membre->getUserIdentifier());
    }
}
