<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function today($user)
    {
        return $this->createQueryBuilder('e')
            ->where('e.utilisateur = :user')
            ->setParameter('user', $user)
            ->andWhere('DATE_DIFF(e.dateDebut, CURRENT_DATE()) = 0')
            ->getQuery()
            ->getResult();
    }

}
