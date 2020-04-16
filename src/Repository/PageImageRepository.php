<?php

namespace App\Repository;

use App\Entity\PageImage;
use App\Model\Images;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method PageImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageImage[]    findAll()
 * @method PageImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageImageRepository extends AbstractRepository
{
    protected $entity = PageImage::class;

    public const PATH = '/images/page-images/';

    /**
     * @param string $page
     * @param UploadedFile $file
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function uploadPageImage(string $page, UploadedFile $file)
    {
        Images::verifyImageFile($file);
        $dir = sprintf('%s/public%s%s/', $this->container->get('kernel')->getProjectDir(), self::PATH, $page);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->getClientOriginalExtension();
        $big = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $big, 600, 600);
        $thumb = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $thumb, 150, 150);

        $item = new PageImage();
        $item->setPage($page);
        $item->setBig($big);
        $item->setThumb($thumb);
        $this->_em->persist($item);
        $this->_em->flush();
    }

}
