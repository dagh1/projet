<?php

namespace App\Repository;

use App\Entity\Societe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Societe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Societe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Societe[]    findAll()
 * @method Societe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocieteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Societe::class);
    }


    public function chercher($donnees)
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.nom', 'ASC');

        if (!empty($donnees['nom'])) {
            $qb->andWhere('s.nom like :nom')
                ->setParameter('nom', '%' . $donnees['nom'] . '%');
        }
        if (!empty($donnees['ville'])) {
            $qb->andWhere('s.ville = :ville')
                ->setParameter('ville', $donnees['ville']);
        }
        if (!empty($donnees['domaine'])) {
            $qb->andWhere(':domaine MEMBER OF s.domaines')
                ->setParameter('domaine', $donnees['domaine']);
        }

        return $qb->getQuery()->getResult();

    }


    /*
    public function findOneBySomeField($value): ?Societe
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
