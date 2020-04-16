<?php


namespace App\Controller;


use App\Entity\GalleryCategory;
use App\Entity\GalleryImage;
use App\Entity\GallerySubcategory;
use App\Entity\MainImage;
use App\Entity\Page;
use App\Entity\PageImage;
use App\Entity\MethodicalDoc;
use App\Repository\GalleryCategoryRepository;
use App\Repository\GalleryImageRepository;
use App\Repository\GallerySubcategoryRepository;
use App\Repository\MainImageRepository;
use App\Repository\PageImageRepository;
use App\Repository\PageRepository;
use App\Repository\MethodicalDocRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

trait RepositoryTrait
{
    /** @var ManagerRegistry */
    private $doctrine;
    /** @var GalleryCategoryRepository */
    private $galleryCategoryRepository;
    /** @var GallerySubcategoryRepository */
    private $gallerySubcategoryRepository;
    /** @var GalleryImageRepository */
    private $galleryImageRepository;
    /** @var PageRepository */
    private $pageRepository;
    /** @var MainImageRepository */
    private $mainImageRepository;
    /** @var MainImage */
    private $mainImage;
    /** @var PageImageRepository */
    private $pageImageRepository;
    /** @var MethodicalDocRepository */
    private $methodicalDocRepository;


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

    /**
     * @return PageRepository
     */
    private function getPageRepository()
    {
        if (empty($this->pageRepository)) {
            $this->pageRepository = $this->doctrine->getRepository(Page::class);
        }

        return $this->pageRepository;
    }

    /**
     * @return MainImageRepository
     */
    protected function getMainImageRepository()
    {
        if (empty($this->mainImageRepository)) {
            $this->mainImageRepository = $this->doctrine->getRepository(MainImage::class);
        }

        return $this->mainImageRepository;
    }

    /**
     * @return MainImage
     */
    protected function getMainImage()
    {
        if (empty($this->mainImage)) {
            $this->mainImage = $this->getMainImageRepository()->findOneBy(['active' => 'yes']);
        }

        return $this->mainImage;
    }

    /**
     * @return PageImageRepository
     */
    protected function getPageImageRepository()
    {
        if (empty($this->pageImageRepository)) {
            $this->pageImageRepository = $this->doctrine->getRepository(PageImage::class);
        }

        return $this->pageImageRepository;
    }

    /**
     * @return MethodicalDocRepository
     */
    protected function getMethodicalDocRepository()
    {
        if (empty($this->methodicalDocRepository)) {
            $this->methodicalDocRepository = $this->doctrine->getRepository(MethodicalDoc::class);
        }

        return $this->methodicalDocRepository;
    }

}