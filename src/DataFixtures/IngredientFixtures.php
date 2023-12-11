<?php

namespace App\DataFixtures;

use App\Entity\Allergene;
use App\Factory\IngredientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $allergenes = $manager->getRepository(Allergene::class);
        $p = json_decode(file_get_contents('src/DataFixtures/data/Recette.json'), true);
        $recIng = [];
        for ($r = 0; $r < sizeof($p); ++$r) {
            $recIng = array_merge($p[$r]['ingredients'], $recIng);
        }
        foreach ($recIng as $i) {
            $ingr = IngredientFactory::createOne(['nomIngr' => $i['nomIngr']]);
            if (null != $i['allergenes']) {
                foreach ($i['allergenes'] as $a) {
                    if (null != $allergenes->findOneBy(['nomAller' => "$a"])) {
                        $ingr->addAllergene($allergenes->findOneBy(['nomAller' => "$a"]));
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AllergeneFixtures::class,
        ];
    }
}
