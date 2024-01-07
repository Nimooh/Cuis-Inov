<?php


namespace App\Tests\Controller\Details;

use App\Entity\Ingredient;
use App\Entity\Unite;
use App\Factory\ComposerFactory;
use App\Factory\IngredientFactory;
use App\Factory\MembreFactory;
use App\Factory\RecetteFactory;
use App\Factory\UniteFactory;
use App\Tests\Support\ControllerTester;
use DateTimeImmutable;

class IndexCest
{
    public function _before(ControllerTester $I)
    {
        RecetteFactory::createOne([
            'nomRecette' => 'test',
            'tempsRecette' => new \DateInterval("PT30M"),
            'diffRecette' => 3,
            'instruction' => 'test
inst',
            'description' => 'test desc',
            'noteMoyenne' => 3.5
        ]);

        $membre = MembreFactory::createOne()->object();
        $I->amLoggedInAs($membre);

        //tests basiques
        $I->amOnPage('/details?id=1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Détails');
    }

    public function areButtonCorrect(ControllerTester $I)
    {
        $I->click('#retour');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInCurrentRoute('app_home');
        $I->seeCurrentTemplateIs('home/index.html.twig');

        //boutons accessibles seulement par un membre
        $I->amOnPage('/details?id=1');
        $I->click('#fav');
        $color = $I->grabAttributeFrom('#hearth', 'fill');
        $I->assertEquals('red', $color);
        $I->click('//*[@id="characteristics"]/div[2]');
        $class = $I->grabAttributeFrom('body', 'class');
        $I->assertEquals('font-cuiInter overflow-hidden', $class);
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
