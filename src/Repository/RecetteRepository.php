<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
            ->addOrderBy('r.noteMoyenne', 'DESC')
            ->addOrderBy('r.nomRecette', 'ASC')
            ->getQuery()
            ->getResult();
        //dump($userFav);

        if(!empty($userFav)) {
            /* Creation de la liste des id, Requete pour recuperer toutes les recettes sauf celle dans la precedente */
            $userFavIds = array_map(fn($recipe) => $recipe['id'], $userFav);
            $qb = $this->createQueryBuilder('r')
                ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 3 AS fav')
                ->where('r.id <> :trending')
                ->andWhere('r.id NOT IN (:userFavIds)')
                ->setParameter('trending', $trendingId)
                ->setParameter('userFavIds', $userFavIds)
                ->addOrderBy('r.noteMoyenne', 'DESC')
                ->addOrderBy('r.nomRecette', 'ASC')
                ->getQuery()
                ->getResult();
            //dump($qb);
            /* Fusion des deux requetes pour avoir toutes les recettes du site affichés triées */
            $mergedResult = array_merge($userFav, $qb);
            usort($mergedResult, function ($a, $b) {
                if ($a['noteMoyenne'] !== $b['noteMoyenne'])
                    return ($a['noteMoyenne'] > $b['noteMoyenne']) ? -1 : 1;

                return strcmp($a['nomRecette'], $b['nomRecette']);
            });
            return $mergedResult;
        } else {
            return $this->createQueryBuilder('r')
                ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 0 AS fav')
                ->where('r.id <> :trending')
                ->setParameter('trending', $trendingId)
                ->addOrderBy('r.noteMoyenne', 'DESC')
                ->addOrderBy('r.nomRecette', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }

    public function findByRecipeId(int $idMember, int $idRecette)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, r.instruction, r.nbPers, i.fav, i.noteRecette')
            ->leftJoin('r.interagirs', 'i', 'WITH', 'i.membre = :idMember')
            ->where('r.id = :idRecette')
            ->setParameter('idRecette', $idRecette)
            ->setParameter('idMember', $idMember)
            ->getQuery()
            ->getSingleResult();
    }

    public function updateAverageNote(int $idRecipe)
    {
        $notes = $this->createQueryBuilder('r')
            ->select('i.noteRecette')
            ->leftJoin('r.interagirs', 'i')
            ->where('r.id = :idRecipe')
            ->setParameter('idRecipe', $idRecipe)
            ->getQuery()
            ->getResult();

        $tot = 0;

        dump($notes);

        foreach ($notes as $note)
        {
            $tot += $note["noteRecette"];
        }

        $avg = $tot / count($notes);

        $this->createQueryBuilder('r2')
            ->update('App:Recette', 'r2')
            ->set('r2.noteMoyenne', ':avg')
            ->where('r2.id = :idRecipe')
            ->setParameter('idRecipe', $idRecipe)
            ->setParameter('avg', $avg)
            ->getQuery()
            ->execute();
    }
}