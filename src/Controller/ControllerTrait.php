<?php


namespace App\Controller;


use App\Entity\GalleryCategory;
use App\Entity\GalleryImage;
use App\Entity\GallerySubcategory;
use App\Repository\GalleryCategoryRepository;
use App\Repository\GalleryImageRepository;
use App\Repository\GallerySubcategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

trait ControllerTrait
{
    /** @var ManagerRegistry */
    private $doctrine;
    /** @var GalleryCategoryRepository */
    private $galleryCategoryRepository;
    /** @var GallerySubcategoryRepository */
    private $gallerySubcategoryRepository;
    /** @var GalleryImageRepository */
    private $galleryImageRepository;

    /**
     * @required
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return GalleryCategoryRepository|ObjectRepository
     */
    private function getGalleryCategoryRepository()
    {
        if (empty($this->galleryCategoryRepository)) {
            $this->galleryCategoryRepository = $this->doctrine->getRepository(GalleryCategory::class);
        }

        return $this->galleryCategoryRepository;
    }

    /**
     * @return GallerySubcategoryRepository|ObjectRepository
     */
    private function getGallerySubcategoryRepository()
    {
        if (empty($this->gallerySubcategoryRepository)) {
            $this->gallerySubcategoryRepository = $this->doctrine->getRepository(GallerySubcategory::class);
        }

        return $this->gallerySubcategoryRepository;
    }

    /**
     * @return GalleryImageRepository
     */
    private function getGalleryImageRepository()
    {
        if (empty($this->galleryImageRepository)) {
            $this->galleryImageRepository = $this->doctrine->getRepository(GalleryImage::class);
        }

        return $this->galleryImageRepository;
    }


}