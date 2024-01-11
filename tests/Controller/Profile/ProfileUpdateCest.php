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

    public function canUpdateProfile(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne([
            'email' => 'a@a.com',
        ])->object();

        $I->amLoggedInAs($membre);
        $I->amOnRoute('app_profile_update');
        $I->submitForm('#form_profile', [
            'profile[email]' => 'a@b.com',
            'profile[password]' => 'a',
            'profile[nomMembre]' => 'Ada',
            'profile[prnmMembre]' => 'Adala',
            'profile[telMembre]' => '0102030405',
        ]);
        $I->seeCurrentRouteIs('app_profile');
        $I->see('a@b.com', "td");
    }

    public function canCancelUpdate(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile/update');
        $I->click('Annuler');
        $I->seeCurrentRouteIs('app_profile');
        $I->see($membre->getUserIdentifier(), "td");
    }

}
