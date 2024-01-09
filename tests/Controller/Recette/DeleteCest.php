<?php

namespace App\Tests\Controller\Recette;

use App\Factory\MembreFactory;
use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class DeleteCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        RecetteFactory::createOne();

        $I->amOnRoute('app_crud_recette_delete', ['id' => '1']);
        $I->seeCurrentRouteIs('app_login');
    }

    public function accessIsRestrictedToOwners(ControllerTester $I): void
    {
        $recette = RecetteFactory::createOne([
            'nomRecette' => 'Bûche de Noël',
            'tempsRecette' => new \DateInterval('PT20M'),
        ])->object();
        $user = MembreFactory::createOne()->object();

        $I->amLoggedInAs($user);

        /*        $user->addRecette($recette); */

        $I->amOnRoute('app_crud_recette_delete', ['id' => $recette->getId()]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
