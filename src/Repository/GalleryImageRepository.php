<?php

namespace App\Repository;

use App\Entity\GalleryImage;
use App\Model\Images;
use App\Model\Tools;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method GalleryImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryImage[]    findAll()
 * @method GalleryImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryImageRepository extends ServiceEntityRepository
{
    /** @var ContainerInterface  */
    private $container;

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct($registry, GalleryImage::class);
    }

    /**
     * @param int $id
     * @return GalleryImage
     * @throws Exception
     */
    public function getById(int $id)
    {
        $item = $this->find($id);
        if (!$item) {
            throw new Exception('Картинка не найдена');
        }

        return $item;
    }


    /**
     * @param int $categoryId
     * @param int $subcategoryId
     * @param UploadedFile $file
     * @throws Exception
     */
    public function saveFile(int $categoryId, int $subcategoryId, UploadedFile $file): void
    {
        if ($file->getError() != 0) {
            throw new Exception($file->getErrorMessage());
        }
        if (!Tools::isImage($file->getMimeType())) {
            throw new Exception('Файл не является картинкой');
        }
        $dir = sprintf(
            '%s/public/images/gallery/%d/%d/',
            $this->container->get('kernel')->getProjectDir(),
            $categoryId,
            $subcategoryId
        );
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->getClientOriginalExtension();
        $big = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $big, 600, 600);
        $thumb = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $thumb, 150, 150);

        $item = new GalleryImage();
        $item->setCategoryId($subcategoryId);
        $item->setSubcategoryId($subcategoryId);
        $item->setBig($big);
        $item->setThumb($thumb);
        $this->_em->persist($item);
        $this->_em->flush();
    }

    /**
     * @param string $ext
     * @return string
     * @throws NonUniqueResultException
     */
    private function getImageFileName(string $ext)
    {
        $name = sprintf('%s.%s', Tools::generateDigitCode(6), $ext);
        $query = $this->createQueryBuilder('gi')
            ->select('gi')
            ->where('gi.big = :name OR gi.thumb = :name')
            ->setParameter('name', $name);
        $item = $query->getQuery()->getOneOrNullResult();
        if ($item) {
            return $this->getImageFileName($ext);
        }

        return $name;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id)
    {
        $item = $this->getById($id);
        $this->_em->remove($item);
        $this->_em->flush();
    }
}
