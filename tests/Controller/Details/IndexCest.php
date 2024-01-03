<?php


namespace App\Tests\Controller\Details;

use App\Entity\Ingredient;
use App\Entity\Unite;
use App\Factory\ComposerFactory;
use App\Factory\IngredientFactory;
use App\Factory\RecetteFactory;
use App\Factory\UniteFactory;
use App\Tests\Support\ControllerTester;
use DateTimeImmutable;

class IndexCest
{
    public $backButton = "#top:first-child";
    public $favButton = "#top:last-child";
    public $compButton = "#button_comp";
    public $recipeButton = "#button_reci";
    public function _before(ControllerTester $I)
    {
        RecetteFactory::createOne([
            'nomRecette' => 'test',
            'tempsRecette' => new DateTimeImmutable('00:30:00'),
            'diffRecette' => 3,
            'instruction' => 'test
inst',
            'description' => 'test desc',
            'noteMoyenne' => 3.5
        ]);
        //tests basiques
        $I->amOnPage('/details?id=1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Détails');
    }

    public function areButtonCorrect(ControllerTester $I)
    {
        $I->click($this->backButton);
        $I->seeCurrentTemplateIs('home/index.html.twig');
        $I->seeInCurrentRoute('app_home');
        $I->amOnPage('/details?id=1');
        $I->click($this->favButton);
        $I->click($this->compButton);
        $myClass = $I->grabAttributeFrom('#components', 'class');
        $I->assertEquals('grid grid-cols-3 md:grid-cols-5 gap-4', $myClass);
        $I->click($this->recipeButton);
        $myClass = $I->grabAttributeFrom('#instruction', 'class');
        $I->assertEquals('flex flex-col gap-2 lg:gap-5 ml-2 mr-2 lg:ml-5 lg:mr-5', $myClass);
    }

    public function isDataInRightPlace(ControllerTester $I)
    {
        IngredientFactory::createMany(5);
        UniteFactory::createMany(2);
        ComposerFactory::createMany(5, function () {
            return [
                'recette' => RecetteFactory::first(),
                'ingredient' => IngredientFactory::random(),
                'unite' => UniteFactory::random(),
                'qte' => 1.1];
        });
        $I->amOnPage('/details?id=1');
        $I->seeInCurrentRoute('app_details');
        $I->seeCurrentTemplateIs('details/index.html.twig');
        //tests des données
        //titre
        $I->see('test', ['css' => ' #details > p']);
        //description
        $I->see('test desc', ['css' => ' #details:nth-child(2)']);
        //caractéristique
        $I->see('30 minutes', '#time');
        $I->see('3.5', '#note');
        $I->see('DIFFICILE', '#diff');
        //instruction
        $lst = $I->grabMultiple('#instruction > p');
        $I->assertEquals(['test', 'inst'], $lst);
        //ingredients
        $I->seeNumberOfElements('#components > div', 5);
    }
}
