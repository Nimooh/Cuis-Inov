<?php


namespace App\Tests\Controller\Interagir;

use App\Entity\Membre;
use App\Factory\MembreFactory;
use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;

class InteragirCest
{
    public function accessIsRestrictedToNonAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/favoris');
        $I->seeCurrentRouteIs('app_login');
    }

    public function accessGrantedToAuthenticatedUsers(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        $I->amOnPage('/favoris');
        $I->seeCurrentRouteIs('app_favoris');
    }

    public function AlternativeRenderingFor0Favoris(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        $I->amOnPage('/favoris');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Vous n\'avez aucun favoris', 'h1');
    }


}
