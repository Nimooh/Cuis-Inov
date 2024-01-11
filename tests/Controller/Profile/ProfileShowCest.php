<?php


namespace App\Tests\Controller\Profile;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;

class ProfileShowCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/profile');
        $I->seeCurrentRouteIs('app_login');
    }

    public function isDataLoaded(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile');
        $I->seeInTitle($membre->getPrnmMembre()." ".$membre->getNomMembre());
        $I->see("Mon Profil", 'h1');
        $I->see("Mes Allergènes", 'h1');
        $I->see($membre->getUserIdentifier(), "td");
    }

    public function canAccessUpdateProfile(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile');
        $I->click('Editer Profil');
        $I->seeCurrentRouteIs('app_profile_update');
        $I->seeInTitle("Edition de ".$membre->getPrnmMembre()." ".$membre->getNomMembre());
    }

    public function canAccessProfileRecipes(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();

        $I->amLoggedInAs($membre);
        $I->amOnPage('/profile');
        $I->click('Mes Recettes');
        $I->seeCurrentRouteIs('app_crud_mes_recettes');
    }
}
