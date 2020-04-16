<?php

namespace App\Repository;

use App\Entity\GameRoomCategory;
use App\Model\Images;
use App\Model\Tools;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method GameRoomCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameRoomCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameRoomCategory[]    findAll()
 * @method GameRoomCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRoomCategoryRepository extends AbstractRepository
{
    protected $entity = GameRoomCategory::class;
    public const PATH = '/images/room-categories/';

    /**
     * @param UploadedFile $file
     * @param string $title
     * @throws Exception
     */
    public function addCategory(UploadedFile $file, string $title)
    {
        Tools::verifyImageFile($file);
        $ext = $file->getClientOriginalExtension();
        $icon = $this->getIconFileName($ext);
        /** @var GameRoomCategory $item */
        $item = new GameRoomCategory();
        $item->setTitle($title);
        $item->setIcon($icon);
        $item->setActive('yes');
        $this->_em->persist($item);
        $this->_em->flush();

        $dir = sprintf('%s/public%s', $this->projectDir, self::PATH);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        Images::createGD($file->getRealPath(), $dir, $icon, 150, 150);
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function deleteCategory(int $id)
    {
        /** @var GameRoomCategory $item */
        $item = $this->getById($id);
        unlink(sprintf('%s/public%s%s', $this->projectDir, self::PATH, $item->getIcon()));
        $this->delete($id);
    }


}
