<?php

namespace App\Factory;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Membre>
 *
 * @method        Membre|Proxy create(array|callable $attributes = [])
 * @method static Membre|Proxy createOne(array $attributes = [])
 * @method static Membre|Proxy find(object|array|mixed $criteria)
 * @method static Membre|Proxy findOrCreate(array $attributes)
 * @method static Membre|Proxy first(string $sortedField = 'id')
 * @method static Membre|Proxy last(string $sortedField = 'id')
 * @method static Membre|Proxy random(array $attributes = [])
 * @method static Membre|Proxy randomOrCreate(array $attributes = [])
 * @method static MembreRepository|RepositoryProxy repository()
 * @method static Membre[]|Proxy[] all()
 * @method static Membre[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Membre[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Membre[]|Proxy[] findBy(array $attributes)
 * @method static Membre[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Membre[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class MembreFactory extends ModelFactory
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
            'email' => 'test@test.com',
            'nomMembre' => 'NomTest',
            'password' => 'test',
            'prnmMembre' => 'PrenomTest',
            'roles' => [''],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Membre $membre): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Membre::class;
    }
}
