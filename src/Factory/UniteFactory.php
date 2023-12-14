<?php

namespace App\Factory;

use App\Entity\Unite;
use App\Repository\UniteRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Unite>
 *
 * @method        Unite|Proxy create(array|callable $attributes = [])
 * @method static Unite|Proxy createOne(array $attributes = [])
 * @method static Unite|Proxy find(object|array|mixed $criteria)
 * @method static Unite|Proxy findOrCreate(array $attributes)
 * @method static Unite|Proxy first(string $sortedField = 'id')
 * @method static Unite|Proxy last(string $sortedField = 'id')
 * @method static Unite|Proxy random(array $attributes = [])
 * @method static Unite|Proxy randomOrCreate(array $attributes = [])
 * @method static UniteRepository|RepositoryProxy repository()
 * @method static Unite[]|Proxy[] all()
 * @method static Unite[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Unite[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Unite[]|Proxy[] findBy(array $attributes)
 * @method static Unite[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Unite[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class UniteFactory extends ModelFactory
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
            'nomUnit' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Unite $unite): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Unite::class;
    }
}
