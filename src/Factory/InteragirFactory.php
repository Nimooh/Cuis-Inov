<?php

namespace App\Factory;

use App\Entity\Interagir;
use App\Repository\InteragirRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Interagir>
 *
 * @method        Interagir|Proxy create(array|callable $attributes = [])
 * @method static Interagir|Proxy createOne(array $attributes = [])
 * @method static Interagir|Proxy find(object|array|mixed $criteria)
 * @method static Interagir|Proxy findOrCreate(array $attributes)
 * @method static Interagir|Proxy first(string $sortedField = 'id')
 * @method static Interagir|Proxy last(string $sortedField = 'id')
 * @method static Interagir|Proxy random(array $attributes = [])
 * @method static Interagir|Proxy randomOrCreate(array $attributes = [])
 * @method static InteragirRepository|RepositoryProxy repository()
 * @method static Interagir[]|Proxy[] all()
 * @method static Interagir[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Interagir[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Interagir[]|Proxy[] findBy(array $attributes)
 * @method static Interagir[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Interagir[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class InteragirFactory extends ModelFactory
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
        return [
            'fav' => self::faker()->boolean(),
            'noteRecette' => self::faker()->numberBetween(1,5),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Ingredient $ingredient): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Interagir::class;
    }
}
