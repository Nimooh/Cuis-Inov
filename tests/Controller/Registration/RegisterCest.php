<?php

namespace App\Tests\Controller\Registration;

use App\Factory\RecetteFactory;
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

    public function registeringBySubmittingDirectly(ControllerTester $I)
    {
        RecetteFactory::createMany(10);

        $I->amOnPage('/register');
        $I->submitForm('#form_register', [
            'registration_form[email]' => 'jean.michel@email.com',
            'registration_form[password]' => new PasswordArgument('password'),
            'registration_form[firstname]' => 'Jean',
            'registration_form[lastname]' => 'Michel',
            'registration_form[address]' => '10 rue de la Villette',
            'registration_form[city]' => 'Monge',
            'registration_form[postalCode]' => '67200',
            'registration_form[phone]' => '0611223344',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_home');
    }

    public function registeringByClicking(ControllerTester $I)
    {
        RecetteFactory::createMany(10);

        $I->amOnPage('/register');
        $I->fillField(['id' => 'registration_form_email'], 'jean.michel@email.com');
        $I->fillField(['id' => 'registration_form_password'], new PasswordArgument('password'));
        $I->fillField(['id' => 'registration_form_firstname'], 'Jean');
        $I->fillField(['id' => 'registration_form_lastname'], 'Michel');
        $I->fillField(['id' => 'registration_form_address'], '10 rue de la Villette');
        $I->fillField(['id' => 'registration_form_city'], 'Monge');
        $I->fillField(['id' => 'registration_form_postalCode'], '67200');
        $I->fillField(['id' => 'registration_form_phone'], '0611223344');
        $I->click("S'inscrire");
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_home');
    }

    public function failTestEmptyForm(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->submitForm('#form_register', [
            'registration_form[email]' => '',
            'registration_form[password]' => '',
            'registration_form[firstname]' => '',
            'registration_form[lastname]' => '',
            'registration_form[address]' => '',
            'registration_form[city]' => '',
            'registration_form[postalCode]' => '',
            'registration_form[phone]' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeCurrentRouteIs('app_register');
    }

    public function failTestWrongEmail(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->submitForm('#form_register', [
            'registration_form[email]' => 'a@a',
            'registration_form[password]' => 'password',
            'registration_form[firstname]' => 'Jean',
            'registration_form[lastname]' => 'Michel',
            'registration_form[address]' => '10 rue de la Villette',
            'registration_form[city]' => 'Monge',
            'registration_form[postalCode]' => '67200',
            'registration_form[phone]' => '0611223344',
        ]);
        $I->see('Cette valeur n\'est pas une adresse email valide');
        $I->seeCurrentRouteIs('app_register');
    }

    public function failTestWrongPhoneNumberString(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->submitForm('#form_register', [
            'registration_form[email]' => 'jean.michel@email.com',
            'registration_form[password]' => 'password',
            'registration_form[firstname]' => 'Jean',
            'registration_form[lastname]' => 'Michel',
            'registration_form[address]' => '10 rue de la Villette',
            'registration_form[city]' => 'Monge',
            'registration_form[postalCode]' => '67200',
            'registration_form[phone]' => 'a',
        ]);
        $I->see('Format de téléphone invalide');
        $I->seeCurrentRouteIs('app_register');
    }

    public function failTestWrongPhoneNumberNotLongEnough(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->submitForm('#form_register', [
            'registration_form[email]' => 'jean.michel@email.com',
            'registration_form[password]' => 'password',
            'registration_form[firstname]' => 'Jean',
            'registration_form[lastname]' => 'Michel',
            'registration_form[address]' => '10 rue de la Villette',
            'registration_form[city]' => 'Monge',
            'registration_form[postalCode]' => '67200',
            'registration_form[phone]' => '01',
        ]);
        $I->see('Format de téléphone invalide');
        $I->seeCurrentRouteIs('app_register');
    }

}
