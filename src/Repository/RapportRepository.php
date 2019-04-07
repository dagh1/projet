<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rapport::class);
    }



    public function chercher($donnees)
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.titre', 'ASC');

        if (!empty($donnees['titre'])) {
            $qb->andWhere('s.titre like :titre')
                ->setParameter('titre', '%' . $donnees['titre'] . '%');
        }
        if (!empty($donnees['domaine'])) {
            $qb->andWhere('s.domaine = :domaine')
                ->setParameter('domaine', $donnees['domaine']);
        }

        return $qb->getQuery()->getResult();

    }
    // /**
    //  * @return Rapport[] Returns an array of Rapport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rapport
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
