<?php

namespace App\DataFixtures;

use App\Entity\CategorieRecette;
use App\Entity\Composer;
use App\Entity\Ingredient;
use App\Entity\Unite;
use App\Factory\RecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecetteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $categories = $manager->getRepository(CategorieRecette::class);
        $composers = $manager->getRepository(Composer::class);
        $ingredients = $manager->getRepository(Ingredient::class);
        $unites = $manager->getRepository(Unite::class);
        $p = json_decode(file_get_contents('src/DataFixtures/data/Recette.json'), true);
        foreach ($p as $r) {
            $time = new \DateTime('00:00:00');
            $recette = RecetteFactory::createOne(['nomRecette' => $r['name'], 'noteMoyenne' => $r['stars_recette'], 'tempsRecette' => $time->add(new \DateInterval("PT{$r['temps_recette']}M")), 'diffRecette' => $r['diff_recette'], 'instruction' => $r['instructions'], 'description' => $r['description']]);
            foreach ($r['categories'] as $cat) {
                $recette->addCategoriesRecette($categories->findOneBy(['nomCatRecette' => $cat['nomCatRecette']]));
            }
            foreach ($r['ingredients'] as $ing) {
                $composer = $composers->findOneBy(['recette' => null, 'ingredient' => $ingredients->findOneBy(['nomIngr' => $ing['nomIngr']]), 'unite' => $unites->findOneBy(['nomUnit' => $ing['unit']]), 'qte' => (int) $ing['quantity']]);
                $recette->addComposer($composer);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategorieRecetteFixtures::class,

            ComposerFixtures::class,
        ];
    }
}
