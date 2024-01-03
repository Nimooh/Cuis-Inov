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

    public function timesOfLiInListIsCorrect(ControllerTester $I): void
    {
        RecetteFactory::createMany(15);

        $I->amOnPage('/');
        $I->seeNumberOfElements('#trending', 1);
        $I->seeNumberOfElements('div#bloc_list > ul > li', 14);
    }

    public function isLinkCorrect(ControllerTester $I): void
    {
        RecetteFactory::createMany(15);

        $I->amOnPage('/');
        $I->click('div#bloc_list > ul > li > a:first-of-type');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_details');

    }

    public function isOrderCorrect(ControllerTester $I): void
    {
        RecetteFactory::createSequence(
            [
                ['nomRecette' => 'Chocolat',
                    'tempsRecette' => new \DateTime('02:36:00'),
                    'diffRecette' => 3,
                    'instruction' => 'Le Lorem Ipsum est un texte employé dans la composition et la mise en page.',
                    'description' => 'Une recette test',
                    'noteMoyenne' => 5,
                ],
                ['nomRecette' => 'Tarte',
                    'tempsRecette' => new \DateTime('02:36:00'),
                    'diffRecette' => 3,
                    'instruction' => 'Le Lorem Ipsum est un texte employé dans la composition et la mise en page.',
                    'description' => 'Une recette test',
                    'noteMoyenne' => 2.16,
                ],
                ['nomRecette' => 'Flanc',
                    'tempsRecette' => new \DateTime('02:36:00'),
                    'diffRecette' => 3,
                    'instruction' => 'Le Lorem Ipsum est un texte employé dans la composition et la mise en page.',
                    'description' => 'Une recette test',
                    'noteMoyenne' => 3.1415,
                ],
                ['nomRecette' => 'Gauffre',
                    'tempsRecette' => new \DateTime('02:36:00'),
                    'diffRecette' => 3,
                    'instruction' => 'Le Lorem Ipsum est un texte employé dans la composition et la mise en page.',
                    'description' => 'Une recette test',
                    'noteMoyenne' => 3.1415,
                ],
            ]
        );

        $I->amOnPage('/');
        $aLinkText = $I->grabMultiple('div#bloc_list > ul > li > a > div > span.text-xl.w-64.text-center');
        //Test ordre décroissant sur la note, PUIS, alphabétique sur le nom (sachant que chocolat ira dans le #trending)
        $I->assertEqualsIgnoringCase(['Flanc','Gauffre','Tarte'], $aLinkText, 'Les deux arrays ne sont pas égales');
    }

}
