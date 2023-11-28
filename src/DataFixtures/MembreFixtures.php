<?php

namespace App\DataFixtures;

use App\Factory\MembreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MembreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MembreFactory::createOne([
            'email' => 'admin@email.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'admin',
            'nom_membre' => 'Smith',
            'prnm_membre' => 'John',
        ]);

        MembreFactory::createOne([
            'email' => 'user@email.com',
            'roles' => ['ROLE_USER'],
            'password' => 'user',
            'nom_membre' => 'Snow',
            'prnm_membre' => 'Jane',
        ]);

        MembreFactory::createMany(10);

        $manager->flush();
    }
}
