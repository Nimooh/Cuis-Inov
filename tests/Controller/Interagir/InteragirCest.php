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

}
