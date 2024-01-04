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

    /**
     * @return Recette[]
     */
    public function findAllOrderedWithoutMostTrending(int $trendingId, int $userId): array
    {
        //Faire 2 requetes : 1 qui recupere toutes les recettes, et 2 qui recupere false de partout sauf ou c'est fav:true
        $conn = $this->getEntityManager()->getConnection();

        $sql ='
        SELECT r.id, r.nom_recette, r.temps_recette, r.diff_recette, r.description, r.note_moyenne, null AS fav
        FROM recette r
        WHERE r.id <> :trending
            AND r.id NOT IN (
                SELECT r.id
                FROM recette r
                    LEFT JOIN interagir i  ON r.id = i.recette_id
                WHERE r.id <> :trending
                    AND i.membre_id = :userId
            )
        UNION 
        SELECT  r.id, r.nom_recette, r.temps_recette, r.diff_recette, r.description, r.note_moyenne, i.fav
        FROM recette r
            LEFT JOIN interagir i  ON r.id = i.recette_id
        WHERE r.id <> :trending
            AND i.membre_id = :userId
        ORDER BY note_moyenne DESC, nom_recette ASC
        ';

        $resultSet = $conn->executeQuery($sql, ['trending' => $trendingId, 'userId' => $userId]);

        return $resultSet->fetchAllAssociative();
    }

    public function findByRecipeId(int $idMember, int $idRecette):array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT r.*, i.fav, note_recette
        FROM recette r
        LEFT JOIN interagir i ON r.id = i.recette_id AND i.membre_id = :idMember
        WHERE r.id = :idRecette;
        ';

        $result = $conn->executeQuery($sql, [
            'idMember' => $idMember,
            'idRecette' => $idRecette]);
        return $result->fetchAssociative();
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
