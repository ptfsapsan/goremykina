<?php

namespace App\Repository;

use App\Entity\GalleryImage;
use App\Model\Images;
use App\Model\Tools;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method GalleryImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryImage[]    findAll()
 * @method GalleryImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryImageRepository extends AbstractRepository
{
    protected $entity = GalleryImage::class;
    public const PATH = '/images/gallery/';

    /**
     * @param int $categoryId
     * @param int $subcategoryId
     * @param UploadedFile $file
     * @throws Exception
     */
    public function saveFile(int $categoryId, int $subcategoryId, UploadedFile $file): void
    {
        Tools::verifyImageFile($file);
        $dir = sprintf(
            '%s/public%s%d/%d/',
            $this->projectDir,
            self::PATH,
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

    public function getByCategoryId(int $id): array
    {
        $images = $this->findBy(['category_id' => $id]);
        $result = [];
        foreach ($images as $image) {
            if (empty($result[$image->getSubcategoryId()])) {
                $result[$image->getSubcategoryId()] = [];
            }
            $result[$image->getSubcategoryId()][] = $image;
        }

        return $result;
    }
}
