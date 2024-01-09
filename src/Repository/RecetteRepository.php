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
        /*Sous requete pour les filtres*/

        $req2 = $this->createQueryBuilder('r')
            ->select('r.id')
            ->leftjoin('r.composers', 'co')
            ->leftjoin('co.ingredient', 'ing')
            ->leftjoin('ing.allergenes', 'al');
        if ($ing_non) {
            $req2->Where('ing.id IN (:ing_non)')
                ->setParameter('ing_non', $ing_non);
        } elseif ($alle) {
            $req2->orWhere('al.id  IN (:alle)')
                ->setParameter('alle', $alle);
        }
        $req_res = $req2->getQuery()->getResult();


        /* Requete pour recuperer toutes les recettes mise en favoris par l'utilisateur */
        $req = $this->createQueryBuilder('r')
            ->select(' distinct r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne')
            ->leftJoin('r.interagirs', 'i')
            ->addSelect('i.fav')
            ->where('r.id <> :trending')
            ->andWhere('i.membre = :userId')
            ->setParameter('trending', $trendingId)
            ->setParameter('userId', $userId)
        ->leftjoin('r.categoriesRecette', 'ca')
        ->leftjoin('r.composers', 'co')
        ->leftjoin('co.ingredient', 'ing')
        ->leftjoin('ing.allergenes', 'al')
        ->andWhere('r.nomRecette LIKE :rece')
        ->setParameter('rece', '%'.$rece.'%');
        if ($diff) {
            $req->andWhere('r.diffRecette IN (:diff)')
                ->setParameter('diff', $diff);
        } elseif ($temp) {
            $req->andWhere('r.diffRecette IN (:temp)')
                ->setParameter('temp', $temp);
        }

        $userFav = $req->addOrderBy('r.noteMoyenne', 'DESC')
            ->addOrderBy('r.nomRecette', 'ASC')
            ->getQuery()
            ->getResult();
        // dump($userFav);

        if (!empty($userFav)) {
            /* Creation de la liste des id, Requete pour recuperer toutes les recettes sauf celle dans la precedente */
            $userFavIds = array_map(fn ($recipe) => $recipe['id'], $userFav);
            $req = $this->createQueryBuilder('r')
                ->select('distinct r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 3 AS fav')
                ->where('r.id <> :trending')
                ->andWhere('r.id NOT IN (:userFavIds)')
                ->setParameter('trending', $trendingId)
                ->setParameter('userFavIds', $userFavIds)

                ->leftjoin('r.categoriesRecette', 'ca')
                ->leftjoin('r.composers', 'co')
                ->leftjoin('co.ingredient', 'ing')
                ->leftjoin('ing.allergenes', 'al')
                ->andWhere('r.nomRecette LIKE :rece')
                ->setParameter('rece', '%'.$rece.'%');
            if ($diff) {
                $req->andWhere('r.diffRecette IN (:diff)')
                    ->setParameter('diff', $diff);
            } elseif ($temp) {
                $req->andWhere('r.tempsRecette IN (:temp)')
                    ->setParameter('temp', $temp);
            } elseif ($note) {
                $req->andWhere('r.noteMoyenne IN (:note)')
                    ->setParameter('note', $note);
            } elseif ($ing_oui) {
                $req->andWhere('ing.id IN (:ing_oui)')
                    ->setParameter('ing_oui', $ing_oui);
            } elseif ($cate) {
                $req->andWhere('ca.id IN (:cate)')
                    ->setParameter('cate', $cate);
            } elseif ($ing_non || $alle) {

                if($req_res){
                $req->andWhere('r.id NOT IN (:req)')
                    ->setParameter('req', $req_res);
                }
            }

            $qb = $req->addOrderBy('r.noteMoyenne', 'DESC')
                ->addOrderBy('r.nomRecette', 'ASC')
                ->getQuery()
                ->getResult();

            // dump($qb);
            /* Fusion des deux requetes pour avoir toutes les recettes du site affichés triées */
            $mergedResult = array_merge($userFav, $qb);
            usort($mergedResult, function ($a, $b) {
                if ($a['noteMoyenne'] !== $b['noteMoyenne']) {
                    return ($a['noteMoyenne'] > $b['noteMoyenne']) ? -1 : 1;
                }

                return strcmp($a['nomRecette'], $b['nomRecette']);
            });

            return $mergedResult;
        } else {
            $req = $this->createQueryBuilder('r')
                ->select('distinct r.id, r.nomRecette, r.tempsRecette, r.diffRecette, r.description, r.noteMoyenne, 0 AS fav')
                ->where('r.id <> :trending')
                ->setParameter('trending', $trendingId)
                ->leftjoin('r.categoriesRecette', 'ca')
                ->leftjoin('r.composers', 'co')
                ->leftjoin('co.ingredient', 'ing')
                ->leftjoin('ing.allergenes', 'al')
                ->andWhere('r.nomRecette LIKE :rece')
                ->setParameter('rece', '%'.$rece.'%');
            if ($diff) {
                $req->andWhere('r.diffRecette IN (:diff)')
                    ->setParameter('diff', $diff);
            } elseif ($temp) {
                $req->andWhere('r.tempsRecette IN (:temp)')
                    ->setParameter('temp', $temp);
            } elseif ($note) {
                $req->andWhere('r.noteMoyenne IN (:note)')
                    ->setParameter('note', $note);
            } elseif ($ing_oui) {
                $req->andWhere('ing.id IN (:ing_oui)')
                    ->setParameter('ing_oui', $ing_oui);
            } elseif ($cate) {
                $req->andWhere('ca.id IN (:cate)')
                    ->setParameter('cate', $cate);
            } elseif ($ing_non || $alle) {
                $req2 = $this->createQueryBuilder('r')
                    ->select('r.id')
                    ->leftjoin('r.composers', 'co')
                    ->leftjoin('co.ingredient', 'ing')
                    ->leftjoin('ing.allergenes', 'al');
                if($req_res){
                    $req->andWhere('r.id NOT IN (:req)')
                        ->setParameter('req', $req_res);
                }
            }

            return $req->addOrderBy('r.noteMoyenne', 'DESC')
                ->addOrderBy('r.nomRecette', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }

    public function findByRecipeId(int $idMember, int $idRecette): array
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

        foreach ($notes as $note) {
            $tot += $note['noteRecette'];
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
