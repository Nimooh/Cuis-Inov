<?php

namespace App\DataFixtures;

use App\Factory\MembreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MembreFactory::createMany(75);
    }
}
