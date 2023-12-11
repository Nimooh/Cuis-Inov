<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Unite;
use App\Factory\ComposerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ComposerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $ingredients = $manager->getRepository(Ingredient::class);
        $unites = $manager->getRepository(Unite::class);

        $p = json_decode(file_get_contents('src/DataFixtures/data/Recette.json'), true);
        $recIng = [];
        for ($r = 0; $r < sizeof($p); ++$r) {
            $recIng = array_merge($p[$r]['ingredients'], $recIng);
        }
        foreach ($recIng as $ing) {
            $composer = ComposerFactory::createOne(['ingredient' => $ingredients->findOneBy(['nomIngr' => $ing['nomIngr']]), 'unite' => $unites->findOneBy(['nomUnit' => $ing['unit']]), 'qte' => (int) $ing['quantity']]);

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            IngredientFixtures::class,
            UniteFixtures::class,
        ];
    }
}
