<?php

namespace App\DataFixtures;

use App\Factory\CategorieRecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieRecetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $p = json_decode(file_get_contents('src/DataFixtures/data/CategorieRecette.json'), true);
        foreach ($p as $c) {
            CategorieRecetteFactory::createOne($c);
        }
        $manager->flush();
    }
}
