<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    //    /**
    //     * @return Review[] Returns an array of Review objects
    //     */
    public function findByMovieAndUser($movieId, $userId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.movie = :movie')
            ->andWhere('m.user = :user')
            ->setParameter('movie', $movieId)
            ->setParameter('user', $userId)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Review
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getAverageRatebyMovieId($movieId): float|null
    {
        return $this->createQueryBuilder('r')
            ->select('AVG(r.rate) as averageRate')
            ->where('r.movie = :movieId')
            ->setParameter('movieId', $movieId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
