<?php

namespace App\DataFixtures;

use App\Factory\UniteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UniteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $p = json_decode(file_get_contents('src/DataFixtures/data/Unite.json'), true);
        foreach ($p as $u) {
            UniteFactory::createOne($u);
        }
        $manager->flush();
    }
}
