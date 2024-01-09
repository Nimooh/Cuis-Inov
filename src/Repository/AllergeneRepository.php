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
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT a.id, a.nom_aller
            FROM allergene a, membre_allergene ma, membre m
            WHERE a.id = ma.allergene_id
              AND ma.membre_id = m.id
              AND m.id = :id
            ';

        $resultSet = $conn->executeQuery($sql, ['id' => $id]);

        return $resultSet->fetchAllAssociative();
    }
}

