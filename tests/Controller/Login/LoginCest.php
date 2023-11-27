<?php

namespace App\Tests\Controller\Login;

use App\Factory\MembreFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Step\Argument\PasswordArgument;

class LoginCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function pageLoadingCorrectly(ControllerTester $I)
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
        $I->amOnPage('/login');
        $I->submitForm('#login', ['email' => 'jean.michel@email.com', 'password' => new PasswordArgument('password')]);
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
    }

    public function loggingInByClicking(ControllerTester $I)
    {
        MembreFactory::createOne([
            'email' => 'jean.michel@email.com',
            'password' => 'password',
        ]);
        $I->amOnPage('/login');
        $I->fillField('#login input[name=email]', 'jean.michel@email.com');
        $I->fillField('#login input[name=password]', new PasswordArgument('password'));
        $I->click('Se connecter', '#login');
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
    }


}
