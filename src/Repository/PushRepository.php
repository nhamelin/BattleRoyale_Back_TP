<?php

namespace App\Repository;

use App\Entity\Push;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Push|null find($id, $lockMode = null, $lockVersion = null)
 * @method Push|null findOneBy(array $criteria, array $orderBy = null)
 * @method Push[]    findAll()
 * @method Push[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PushRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Push::class);
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
