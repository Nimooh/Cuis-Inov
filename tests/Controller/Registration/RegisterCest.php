<?php

namespace App\Tests\Controller\Registration;

use App\Tests\Support\ControllerTester;
use Codeception\Step\Argument\PasswordArgument;

class RegisterCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function pageRegisterLoadingCorrectly(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Inscription');
    }

    public function registeringByClicking(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->fillField('#form_register input[id=registration_form_email]', 'jean.michel@email.com');
        $I->fillField('#form_register input[id=registration_form_password]', new PasswordArgument('password'));
        $I->fillField('#form_register input[id=registration_form_firstname]', 'Jean');
        $I->fillField('#form_register input[id=registration_form_lastname]', 'Michel');
        $I->fillField('#form_register input[id=registration_form_address]', '10 rue de la Villette');
        $I->fillField('#form_register input[id=registration_form_city]', 'Monge');
        $I->fillField('#form_register input[id=registration_form_postalCode]', '67200');
        $I->fillField('#form_register input[id=registration_form_phone]', '0611223344');
        $I->click("S'inscrire", '#form_register');
        $I->seeResponseCodeIs(200);
    }
}
