<?php

namespace App\Repository;

use App\Entity\MainImage;
use App\Model\Images;
use App\Model\Tools;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method MainImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainImage[]    findAll()
 * @method MainImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainImageRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, MainImage::class, $container);
    }

    /**
     * @param UploadedFile $file
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function saveImage(UploadedFile $file)
    {
        Images::verifyImageFile($file);
        $dir = sprintf(
            '%s/public/images/main-images/',
            $this->container->get('kernel')->getProjectDir()
        );
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->getClientOriginalExtension();
        $big = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $big, 600, 600);
        $thumb = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $thumb, 150, 150);

        $item = new MainImage();
        $item->setBig($big);
        $item->setThumb($thumb);
        $item->setActive('yes');
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

}
