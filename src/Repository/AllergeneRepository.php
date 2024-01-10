<?php

namespace App\Repository;

use App\Entity\Allergene;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Allergene>
 *
 * @method Allergene|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allergene|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allergene[]    findAll()
 * @method Allergene[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllergeneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Allergene::class);
    }

    /**
     * @param int $id Identifiant de l'utilisateur courant
     * @return Allergene[]
     */
    public function findWithMembre(int $id): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.nomAller')
            ->join('a.membres', 'm')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }
}

