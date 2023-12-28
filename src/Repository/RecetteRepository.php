<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 *
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findMostTrending(): ?Recette
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM recette
        WHERE note_moyenne = (SELECT MAX(note_moyenne)
                             FROM recette)
        ';
        $result = $conn->executeQuery($sql);

        $data = $result->fetchAllAssociative();

        $entityManager = $this->getEntityManager();
        return $entityManager->getRepository(Recette::class)->find($data[0]['id']);
    }

    public function findAllOrderedWithoutMostTrending($trendingId): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.interagirs','i')
            ->addSelect('i.fav')
            ->andWhere('r.id <> :trendingId')
            ->setParameter('trendingId', $trendingId)
            ->orderBy('r.noteMoyenne', 'DESC')
            ->addOrderBy('r.nomRecette', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @return Recette[]
     */
    public function findByRecipeId(int $id):array
    {
        return $this->createQueryBuilder('r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findAllComponentsByRecipeId(int $id):array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT i.id, qte, nom_unit, i.nom_ingr
        FROM composer c LEFT JOIN unite u ON (c.unite_id = u.id)
        LEFT JOIN ingredient i ON (c.ingredient_id = i.id)
        WHERE c.recette_id = :id
        ORDER BY i.nom_ingr ASC;
        ';

        $result = $conn->executeQuery($sql, ['id' => $id]);
        return $result->fetchAllAssociative();
    }
}
