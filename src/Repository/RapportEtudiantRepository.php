<?php

namespace App\Repository;

use App\Entity\RapportEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportEtudiant[]    findAll()
 * @method RapportEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportEtudiant::class);
    }

    // /**
    //  * @return RapportEtudiant[] Returns an array of RapportEtudiant objects
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
    public function findOneBySomeField($value): ?RapportEtudiant
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
