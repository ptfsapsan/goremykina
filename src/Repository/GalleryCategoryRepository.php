<?php

namespace App\Repository;

use App\Entity\GalleryCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method GalleryCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryCategory[]    findAll()
 * @method GalleryCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryCategoryRepository extends AbstractRepository
{
    protected $entity = GalleryCategory::class;

    /**
     * @param string $title
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(string $title)
    {
        $item = new GalleryCategory();
        $item->setTitle($title);
        $item->setActive('yes');
        $this->_em->persist($item);
        $this->_em->flush();
    }
}
