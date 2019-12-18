<?php

namespace App\Repository;

use App\Entity\LiveShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LiveShow|null find($id, $lockMode = null, $lockVersion = null)
 * @method LiveShow|null findOneBy(array $criteria, array $orderBy = null)
 * @method LiveShow[]    findAll()
 * @method LiveShow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiveShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LiveShow::class);
    }

    // /**
    //  * @return LiveShow[] Returns an array of LiveShow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LiveShow
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
