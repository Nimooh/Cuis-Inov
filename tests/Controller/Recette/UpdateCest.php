<?php


namespace App\Tests\Controller\Recette;

use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        RecetteFactory::createOne();

        $I->amOnRoute('app_crud_recette_update', ['id' => '1']);
        $I->seeCurrentRouteIs('app_login');
    }
}
