<?php

namespace App\Factory;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Recette>
 *
 * @method        Recette|Proxy create(array|callable $attributes = [])
 * @method static Recette|Proxy createOne(array $attributes = [])
 * @method static Recette|Proxy find(object|array|mixed $criteria)
 * @method static Recette|Proxy findOrCreate(array $attributes)
 * @method static Recette|Proxy first(string $sortedField = 'id')
 * @method static Recette|Proxy last(string $sortedField = 'id')
 * @method static Recette|Proxy random(array $attributes = [])
 * @method static Recette|Proxy randomOrCreate(array $attributes = [])
 * @method static RecetteRepository|RepositoryProxy repository()
 * @method static Recette[]|Proxy[] all()
 * @method static Recette[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Recette[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Recette[]|Proxy[] findBy(array $attributes)
 * @method static Recette[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Recette[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class RecetteFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $minutes = self::faker()->numberBetween(1, 60);
        return [
            'nomRecette' => self::faker()->word(),
            'tempsRecette' => new \DateInterval("PT".$minutes."M"),
            'diffRecette' => self::faker()->numberBetween(1,3),
            'instruction' => self::faker()->paragraph(),
            'description' => self::faker()->sentence(),
            'noteMoyenne' => self::faker()->numberBetween(1,4),
            'nbPers' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Recette $recette): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Recette::class;
    }
}
