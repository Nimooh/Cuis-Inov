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
        $qb = $this->createQueryBuilder('r')
            ->where('r.noteMoyenne = (SELECT MAX(r2.noteMoyenne) FROM App\Entity\Recette r2)')
            ->getQuery();

        //Affichage alternative si la base de données est vide
        $result = null;
        try {
            $result = $qb->getResult()[0];
        } finally {
            return $result;
        }
    }

    /**
     * @return Recette[]
     */
    public function findAllOrderedWithoutMostTrending(int $trendingId, int $userId): array
    {
        /* Requete pour recuperer toutes les recettes mise en favoris par l'utilisateur */
        $userFav = $this->createQueryBuilder('r')
                ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne')
                ->leftJoin('r.interagirs', 'i')
                ->addSelect('i.fav')
                ->where('r.id <> :trending')
                ->andWhere('i.membre = :userId')
                ->setParameter('trending', $trendingId)
                ->setParameter('userId', $userId)
                ->getQuery()
                ->getResult();
        //dump($userFav);

        /* Creation de la liste des id, Requete pour recuperer toutes les recettes sauf celle dans la precedente */
        $userFavIds = array_map(fn($recipe) => $recipe['id'], $userFav);
        $qb = $this->createQueryBuilder('r')
            ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 0 AS fav')
            ->where('r.id <> :trending')
            ->andWhere('r.id NOT IN (:userFavIds)')
            ->setParameter('trending', $trendingId)
            ->setParameter('userFavIds', $userFavIds)
            ->getQuery()
            ->getResult();
        //dump($qb);
        /* Fusion des deux requetes pour avoir toutes les recettes du site affichés */
        return array_merge($userFav, $qb);
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
