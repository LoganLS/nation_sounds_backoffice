<?php

namespace App\Repository;

use App\Entity\MeetArtist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MeetArtist|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetArtist|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetArtist[]    findAll()
 * @method MeetArtist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetArtist::class);
    }

    // /**
    //  * @return MeetArtist[] Returns an array of MeetArtist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeetArtist
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
