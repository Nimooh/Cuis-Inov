<?php

namespace App\Repository;

use App\Entity\Interagir;
use App\Entity\Recette;
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

    /**
     * @param int $id Identifiant de l'utilisateur courant
     * @return Recette[]
     */
    public function findWithMembre(int $id): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.fav')
            ->leftJoin('i.recette', 'r')
            ->addSelect('r.id, r.nomRecette, r.tempsRecette, r.noteMoyenne, r.diffRecette, r.description')
            ->where('i.fav = TRUE')
            ->andWhere('i.membre = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function updateDB(int $fav = 3, int $idMembre, int $idRecette, ?int $noteRecette = null)
    {
        if($fav !== 3) {
            // Inversion de $fav pour mettre à jour la nouvelle valeur
            $fav = $fav ? 0 : 1;

            $this->createQueryBuilder('i')
                ->update('App\Entity\Interagir', 'i')
                ->set('i.fav', ':fav')
                ->where('i.membre = :idMembre')
                ->andWhere('i.recette = :idRecette')
                ->setParameter('fav', $fav)
                ->setParameter('idMembre', $idMembre)
                ->setParameter('idRecette', $idRecette)
                ->getQuery()
                ->getResult()
            ;
        } elseif($noteRecette !== null) {
            $this->createQueryBuilder('i')
                ->update('App\Entity\Interagir', 'i')
                ->set('i.noteRecette', ':noteRecette')
                ->set('i.noteRecette', ':note')
                ->where('i.membre = :idMembre')
                ->andWhere('i.recette = :idRecette')
                ->setParameter('noteRecette', $noteRecette)
                ->setParameter('idMembre', $idMembre)
                ->setParameter('idRecette', $idRecette)
                ->setParameter('note', $noteRecette)
                ->getQuery()
                ->getResult()
            ;
        }

    }

    public function insertDB(int $idMembre, int $idRecette, ?int $fav, ?int $noteRecette = null)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            INSERT INTO interagir (fav, membre_id, recette_id, note_recette)
            VALUES (:fav, :idMembre, :idRecette, :noteRecette)
            ';

        $conn->executeQuery($sql, ['fav' => $fav,
                                    'idMembre' => $idMembre,
                                    'idRecette' => $idRecette,
                                    'noteRecette' => $noteRecette]);
    }
}
