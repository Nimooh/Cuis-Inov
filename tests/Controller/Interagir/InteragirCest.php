<?php


namespace App\Tests\Controller\Interagir;

use App\Factory\InteragirFactory;
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

    public function isTitleCorrect(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        $I->amOnPage('/favoris');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Vos Favoris!');
    }

    public function AlternativeRenderingForZeroFavoris(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        $I->amOnPage('/favoris');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Vous n\'avez aucun favoris', 'h1');
    }

    public function setFavorisIsWorkingCorrectly(ControllerTester $I): void
    {
        RecetteFactory::createMany(10);

        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        $I->amOnPage('/');
        $I->click('div#bloc_list > ul > li > a:last-of-type');
        $I->seeCurrentRouteIs('app_home');
    }

    public function timesOfLiInListIsCorrect(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        InteragirFactory::createMany(15, function () use ($membre) {
            return [
                'fav' => true,
                'membre' => $membre,
                'recette' => RecetteFactory::createOne(),
            ];
        });

        $I->amOnPage('/favoris');
        $I->seeNumberOfElements('div#bloc_list > ul > li', 15);
    }

    public function unlikeARecipeRemoveItFromFavoris(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        InteragirFactory::createMany(15, function () use ($membre) {
            return [
                'fav' => true,
                'membre' => $membre,
                'recette' => RecetteFactory::createOne(),
            ];
        });

        $I->amOnPage('/favoris');
        $I->click('div#bloc_list > ul > li > a:last-of-type');
        $I->seeNumberOfElements('div#bloc_list > ul > li', 14);
    }

    public function isLinkCorrect(ControllerTester $I): void
    {
        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        InteragirFactory::createOne([
                'fav' => true,
                'membre' => $membre,
                'recette' => RecetteFactory::createOne(),
            ]);

        $I->amOnPage('/favoris');
        $I->click('div#bloc_list > ul > li > a:first-of-type');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_details');
    }
}
