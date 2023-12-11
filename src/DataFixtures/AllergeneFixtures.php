<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergeneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $p = json_decode(file_get_contents('src/DataFixtures/data/Allergene.json'), true);
        foreach ($p as $i) {
            AllergeneFactory::createOne($i);
        }
        $manager->flush();
    }
}
