<?php

namespace App\Repository;

use App\Entity\PushEndpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PushEndpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method PushEndpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method PushEndpoint[]    findAll()
 * @method PushEndpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PushEndpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PushEndpoint::class);
    }

    // /**
    //  * @return PushEndpoint[] Returns an array of PushEndpoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PushEndpoint
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
