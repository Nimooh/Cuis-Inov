<?php

namespace App\Repository;

use App\Entity\Interagir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interagir>
 *
 * @method Interagir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interagir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interagir[]    findAll()
 * @method Interagir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteragirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interagir::class);
    }

//    /**
//     * @return Interagir[] Returns an array of Interagir objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Interagir
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
