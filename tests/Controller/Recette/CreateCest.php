<?php

namespace App\Tests\Controller\Recette;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function form(ControllerTester $I): void
    {
        $user = MembreFactory::createOne()->object();

        $I->amLoggedInAs($user);
        $I->amOnPage('/recette/create');
        $I->seeInTitle("Création d'une nouvelle recette");
        $I->see("Création d'une nouvelle recette", 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/recette/create');
        $I->seeCurrentRouteIs('app_login');
    }

    public function canCreateARecipe(ControllerTester $I): void
    {
        $user = MembreFactory::createOne()->object();

        $I->amLoggedInAs($user);
        $I->amOnRoute('app_crud_recette_create');

        $token = $I->grabValueFrom('#recette__token');

        $I->submitForm('#form_crud_recette', [
            'recette[nomRecette]' => 'Test',
            'recette[tempsRecette][minutes]' => '10',
            'recette[diffRecette]' => '1',
            'recette[description]' => '',
            'recette[instruction]' => '',
            'recette[categoriesRecette]' => ['5'],
            'recette[composers][0][qte]' => '1',
            'recette[composers][0][ingredient]' => '60',
            'recette[composers][0][unite]' => '',
            'recette[_token]' => $token,
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_details');
    }
}
