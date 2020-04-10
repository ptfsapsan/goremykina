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
class GalleryCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryCategory::class);
    }

    /**
     * @param int $id
     * @return GalleryCategory|null
     * @throws Exception
     */
    public function getById(int $id)
    {
        $item = $this->findOneBy(['id' => $id]);
        if (!$item) {
            throw new Exception('Не найдена категория');
        }

        return $item;
    }

    /**
     * @param int $id
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function delete(int $id)
    {
        $item = $this->getById($id);
        $this->_em->remove($item);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function changeActive(int $id)
    {
        $item = $this->getById($id);
        $active = $item->getActive() == 'yes' ? 'no' : 'yes';
        $item->setActive($active);
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
