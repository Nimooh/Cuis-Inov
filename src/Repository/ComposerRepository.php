<?php

namespace App\Repository;

use App\Entity\Composer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Composer>
 *
 * @method Composer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composer[]    findAll()
 * @method Composer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Composer::class);
    }

    public function findAllComponentsByRecipeId(int $id):array
    {
        return $this->createQueryBuilder('c')
            ->select('i.id, i.nomIngr, c.qte, u.nomUnit')
            ->leftJoin('c.ingredient', 'i')
            ->leftJoin('c.unite', 'u')
            ->where('c.recette = :idRecipe')
            ->setParameter('idRecipe', $id)
            ->getQuery()
            ->getArrayResult();
        /*
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
        */
    }
}
