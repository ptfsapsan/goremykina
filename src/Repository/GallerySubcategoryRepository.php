<?php

namespace App\Repository;

use App\Entity\GalleryCategory;
use App\Entity\GallerySubcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method GallerySubcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GallerySubcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GallerySubcategory[]    findAll()
 * @method GallerySubcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GallerySubcategoryRepository extends AbstractRepository
{
    protected $entity = GallerySubcategory::class;

    /**
     * @param int $id
     * @param string $title
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(int $id, string $title)
    {
        $item = new GallerySubcategory();
        $item->setCategoryId($id);
        $item->setTitle($title);
        $item->setActive('yes');
        $this->_em->persist($item);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @param string $title
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function changeTitle(int $id, string $title)
    {
        $item = $this->getById($id);
        $item->setTitle($title);
        $this->_em->persist($item);
        $this->_em->flush();
    }

}
