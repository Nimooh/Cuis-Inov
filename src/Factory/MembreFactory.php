<?php

namespace App\Factory;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Membre>
 *
 * @method        Membre|Proxy                     create(array|callable $attributes = [])
 * @method static Membre|Proxy                     createOne(array $attributes = [])
 * @method static Membre|Proxy                     find(object|array|mixed $criteria)
 * @method static Membre|Proxy                     findOrCreate(array $attributes)
 * @method static Membre|Proxy                     first(string $sortedField = 'id')
 * @method static Membre|Proxy                     last(string $sortedField = 'id')
 * @method static Membre|Proxy                     random(array $attributes = [])
 * @method static Membre|Proxy                     randomOrCreate(array $attributes = [])
 * @method static MembreRepository|RepositoryProxy repository()
 * @method static Membre[]|Proxy[]                 all()
 * @method static Membre[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Membre[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Membre[]|Proxy[]                 findBy(array $attributes)
 * @method static Membre[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Membre[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class MembreFactory extends ModelFactory
{
    private \Transliterator $trans;
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->trans = transliterator_create('Any-Lower; Latin-ASCII');
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $nom_membre = self::faker()->lastName();
        $prnm_membre = self::faker()->firstName();

        return [
            'email' => $this->normalizeName($prnm_membre).'.'.$this->normalizeName($nom_membre).self::faker()->numerify('-###').'@'.self::faker()->domainName(),
            'roles' => ['ROLE_USER'],
            'password' => 'test',
            'nomMembre' => $nom_membre,
            'prnmMembre' => $prnm_membre,
            'cpmembre' => str_replace(' ', '', self::faker()->postcode()),
            'adr_membre' => self::faker()->buildingNumber().' '.self::faker()->streetName(),
            'ville_membre' => self::faker()->city(),
            'tel_membre' => '0'.self::faker()->randomDigitNotNull().self::faker()->randomNumber(8, true),
        ];
    }

    protected function normalizeName(string $nom): string
    {
        return preg_replace('/[^a-zA-Z0-9_ ]/', '-', $this->trans->transliterate($nom));
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Membre $membre) {
                $membre->setPassword($this->passwordHasher->hashPassword($membre, $membre->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Membre::class;
    }
}
