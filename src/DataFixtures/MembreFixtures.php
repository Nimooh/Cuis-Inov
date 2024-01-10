<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Entity\Recette;
use App\Factory\MembreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MembreFixtures extends Fixture implements DependentFixtureInterface
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

        $membres = $manager->getRepository(Membre::class);
        $recettes = $manager->getRepository(Recette::class);
        $fakeUser = $membres->findOneBy(['email' => 'user@email.com']);
        $fakeUser->addRecette($recettes->findOneBy(['id' => 1]));

        MembreFactory::createMany(10);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RecetteFixtures::class,
        ];
    }
}
