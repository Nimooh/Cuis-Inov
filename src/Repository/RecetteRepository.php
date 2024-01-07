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

        // Affichage alternative si la base de données est vide
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
    public function findAllOrderedWithoutMostTrending(int $trendingId, int $userId, $rece = '', $diff, $temp, $note, $ing_oui, $ing_non, $cate, $alle): array
    {
        /* Requete pour recuperer toutes les recettes mise en favoris par l'utilisateur */
        $req = $this->createQueryBuilder('r')
            ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne')
            ->leftJoin('r.interagirs', 'i')
            ->addSelect('i.fav')
            ->where('r.id <> :trending')
            ->andWhere('i.membre = :userId')
            ->setParameter('trending', $trendingId)
            ->setParameter('userId', $userId)
        ->join('r.categoriesRecette', 'ca')->join('r.composers', 'co')->join('co.ingredient', 'in')->join('in.allergenes', 'al')
        ->andWhere('r.nomRecette LIKE :rece')
        ->setParameter('rece', '%'.$rece.'%');

        $userFav = $req->addOrderBy('r.noteMoyenne', 'DESC')
         ->addOrderBy('r.nomRecette', 'ASC')
         ->getQuery()
         ->getResult();
        // dump($userFav);

        if (!empty($userFav)) {
            /* Creation de la liste des id, Requete pour recuperer toutes les recettes sauf celle dans la precedente */
            $userFavIds = array_map(fn ($recipe) => $recipe['id'], $userFav);
            $req = $this->createQueryBuilder('r')
                ->select('r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 0 AS fav')
                ->where('r.id <> :trending')
                ->andWhere('r.id NOT IN (:userFavIds)')
                ->setParameter('trending', $trendingId)
                ->setParameter('userFavIds', $userFavIds)

                ->join('r.categoriesRecette', 'ca')->join('r.composers', 'co')->join('co.ingredient', 'ing')->join('ing.allergenes', 'al')
                ->andWhere('r.nomRecette LIKE :rece')
                ->setParameter('rece', '%'.$rece.'%');
            if ($diff) {
                $req->andWhere($req->expr()->in('r.diffRecette ', ' :diff'))
                    ->setParameter('diff', $diff);
            } elseif ($temp) {
                $req->andWhere($req->expr()->in('r.tempsRecette ', ' :temp'))
                    ->setParameter('temp', $temp);
            } elseif ($note) {
                $req->andWhere($req->expr()->in('r.noteMoyenne ', ' :note'))
                    ->setParameter('note', $note);
            } elseif ($ing_oui) {
                $req->andWhere($req->expr()->in('ing.id ', ':ing_oui'))
                    ->setParameter('ing_oui', $ing_oui);
            } elseif ($ing_non) {
                $ing_non = array_map(fn ($ing) => $ing, $ing_non);
                $req->andWhere('ing.id NOT IN (:ing_non)')
                    ->setParameter('ing_non', $ing_non);
            } elseif ($cate) {
                $req->andWhere($req->expr()->in('ca.id ', ' :cate'))
                    ->setParameter('cate', $cate);
            } elseif ($alle) {
                $alle = array_map(fn ($all) => $all['id'], $alle);
                $req->andWhere('al.id NOT IN (:alle)')
                    ->setParameter('alle', $alle);
            }

            $req->addOrderBy('r.noteMoyenne', 'DESC')
                ->addOrderBy('r.nomRecette', 'ASC')
                ->getQuery()
                ->getResult();
            // dump($qb);
            /* Fusion des deux requetes pour avoir toutes les recettes du site affichés triées */
            $mergedResult = array_merge($userFav, $req);
            usort($mergedResult, function ($a, $b) {
                if ($a['noteMoyenne'] !== $b['noteMoyenne']) {
                    return ($a['noteMoyenne'] > $b['noteMoyenne']) ? -1 : 1;
                }

                return strcmp($a['nomRecette'], $b['nomRecette']);
            });

            return $mergedResult;
        } else {
            $req = $this->createQueryBuilder('r')
                ->select('Distinct r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 0 AS fav')
                ->where('r.id <> :trending')
                ->setParameter('trending', $trendingId)
                ->join('r.categoriesRecette', 'ca')->join('r.composers', 'co')->join('co.ingredient', 'ing')->join('ing.allergenes', 'al')
                ->andWhere('r.nomRecette LIKE :rece')
                ->setParameter('rece', '%'.$rece.'%');
            if ($diff) {
                $req->andWhere($req->expr()->in('r.diffRecette ', ' :diff'))
                    ->setParameter('diff', $diff);
            } elseif ($temp) {
                $req->andWhere($req->expr()->in('r.tempsRecette ', ' :temp'))
                    ->setParameter('temp', $temp);
            } elseif ($note) {
                $req->andWhere($req->expr()->in('r.noteMoyenne ', ' :note'))
                    ->setParameter('note', $note);
            } elseif ($ing_oui) {
                $req->andWhere($req->expr()->in('ing.id ', ':ing_oui'))
                    ->setParameter('ing_oui', $ing_oui);
            } elseif ($ing_non) {
                $ing_non = array_map(fn ($ing) => $ing, $ing_non);
                $req->andWhere('ing.id NOT IN (:ing_non)')
                    ->setParameter('ing_non', $ing_non);
            } elseif ($cate) {
                $req->andWhere($req->expr()->in('ca.id ', ' :cate'))
                    ->setParameter('cate', $cate);
            } elseif ($alle) {
                $alle = array_map(fn ($all) => $all['id'], $alle);
                $req->andWhere('al.id NOT IN (:alle)')
                    ->setParameter('alle', $alle);
            }

            return $req->addOrderBy('r.noteMoyenne', 'DESC')
            ->addOrderBy('r.nomRecette', 'ASC')
            ->getQuery()
            ->getResult();
        }
    }

    /**
     * @return Recette[]
     */
    public function findByRecipeId(int $id): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findAllComponentsByRecipeId(int $id): array
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
