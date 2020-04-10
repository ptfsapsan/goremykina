<?php

namespace App\Repository;

use App\Entity\GallerySubcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GallerySubcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GallerySubcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GallerySubcategory[]    findAll()
 * @method GallerySubcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GallerySubcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GallerySubcategory::class);
    }

    // /**
    //  * @return GallerySubcategory[] Returns an array of GallerySubcategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GallerySubcategory
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
