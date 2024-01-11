<?php


namespace App\Tests\Controller\Profile;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;

class ProfileDeleteCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile/delete');
        $I->seeCurrentRouteIs('app_login');
    }

    public function isProfileCorrect(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile/delete');
        $I->see($membre->getPrnmMembre()." ".$membre->getNomMembre(), "div");
        $I->see('Supprimer');
        $I->see('Annuler');
    }

    public function canCancelDelete(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile/delete');
        $I->click('Annuler');
        $I->seeCurrentRouteIs('app_profile_update');
        $I->assertEquals($I->grabValueFrom('#profile_email'), $membre->getUserIdentifier());
    }

    public function canDeleteProfile(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne([
            'email' => 'a@a.com',
            'password' => 'a',
        ])->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile/delete');
        $I->click('Supprimer');
        $I->seeCurrentRouteIs('app_home');
        $I->amOnPage('/login');
        $I->submitForm('#login', [
            'profile[email]' => 'a@a.com',
            'profile[password]' => 'a',
        ]);
        $I->see('Identifiants invalides');
    }
}
