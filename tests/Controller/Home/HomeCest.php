<?php


namespace App\Tests\Controller\Home;

use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;

class HomeCest
{
    public function isTitleCorrect(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Cuis\'inov');
    }

    public function alternativeRenderingWhenDbIsEmpty(ControllerTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Le site est actuellement indisponible.', 'p:first-of-type');
        $I->see('Veuillez réessayer ultérieurement.', 'p:last-of-type');
    }

    public function areElementGenerated(ControllerTester $I): void
    {
        RecetteFactory::createMany(15);

        $I->amOnPage('/');
        $I->seeElement('#trending');
        $I->see('Les mieux notées :', 'h1');
        $I->seeElement('#bloc_list');
    }

}
