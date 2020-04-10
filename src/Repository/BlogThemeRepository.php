<?php

namespace App\Repository;

use App\Entity\BlogTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogTheme[]    findAll()
 * @method BlogTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogTheme::class);
    }

    // /**
    //  * @return BlogTheme[] Returns an array of BlogTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogTheme
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
