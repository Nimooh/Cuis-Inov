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
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT r.id, r.nom_recette, r.temps_recette, r.note_moyenne, r.diff_recette, r.description, i.fav
            FROM recette r
                inner join interagir i ON (r.id = i.recette_id)
            WHERE i.fav IS TRUE
                AND i.membre_id = :id
            ';

        $resultSet = $conn->executeQuery($sql, ['id' => $id]);

        return $resultSet->fetchAllAssociative();
    }

    public function updateDB(?bool $fav = null, int $idMembre, int $idRecette, ?int $noteRecette = null)
    {
        if($fav !== null) {
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
                ->execute()
            ;
        } elseif($noteRecette !== null) {
            $this->createQueryBuilder('i')
                ->update('App\Entity\Interagir', 'i')
                ->set('i.noteRecette', ':noteRecette')
                ->where('i.membre = :idMembre')
                ->andWhere('i.recette = :idRecette')
                ->setParameter('noteRecette', $noteRecette)
                ->setParameter('idMembre', $idMembre)
                ->setParameter('idRecette', $idRecette)
                ->getQuery()
                ->execute()
            ;
        }

    }

    public function insertDB(int $idMembre, int $idRecette, ?int $noteRecette = null)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            INSERT INTO interagir (fav, membre_id, recette_id, note_recette)
            VALUES (1, :idMembre, :idRecette, :noteRecette)
            ';

        $conn->executeQuery($sql, ['idMembre' => $idMembre,
                                                'idRecette' => $idRecette,
                                                'noteRecette' => $noteRecette]);
    }
}
