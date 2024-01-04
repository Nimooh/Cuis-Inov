<?php

namespace App\Tests\Controller\Login;

use App\Factory\MembreFactory;
use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Step\Argument\PasswordArgument;

class LoginCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function pageLoginLoadingCorrectly(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Connexion');
    }

    public function loggingInBySubmittingDirectly(ControllerTester $I)
    {
        MembreFactory::createOne([
            'email' => 'jean.michel@email.com',
            'password' => 'password',
        ]);
        RecetteFactory::createMany(10);

        $I->amOnPage('/login');
        $I->submitForm('#login', ['email' => 'jean.michel@email.com', 'password' => new PasswordArgument('password')]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_home');
    }

    public function loggingInByClicking(ControllerTester $I)
    {
        MembreFactory::createOne([
            'email' => 'jean.michel@email.com',
            'password' => 'password',
        ]);
        RecetteFactory::createMany(10);

        $I->amOnPage('/login');
        $I->fillField(['id' => 'inputEmail'], 'jean.michel@email.com');
        $I->fillField(['id' => 'inputPassword'], new PasswordArgument('password'));
        $I->click('Se connecter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_home');
    }
}
