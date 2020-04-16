<?php

namespace App\Repository;

use App\Entity\GameRoomImage;
use App\Model\Images;
use App\Model\Tools;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method GameRoomImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameRoomImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameRoomImage[]    findAll()
 * @method GameRoomImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRoomImageRepository extends AbstractRepository
{
    protected $entity = GameRoomImage::class;
    public const PATH = '/images/game-room-images/';

    /**
     * @param UploadedFile $file
     * @param int $id
     * @throws Exception
     */
    public function addImage(UploadedFile $file, int $id)
    {
        Tools::verifyImageFile($file);
        $dir = sprintf(
            '%s/public%s',
            $this->projectDir,
            self::PATH
        );
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->getClientOriginalExtension();
        $big = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $big, 600, 600);
        $thumb = $this->getImageFileName($ext);
        Images::createGD($file->getRealPath(), $dir, $thumb, 150, 150);

        $item = new GameRoomImage();
        $item->setCategoryId($id);
        $item->setBig($big);
        $item->setThumb($thumb);
        $this->_em->persist($item);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function deleteImage(int $id)
    {
        /** @var GameRoomImage $item */
        $item = $this->getById($id);
        unlink(sprintf('%s/public%s%s', $this->projectDir, self::PATH, $item->getBig()));
        unlink(sprintf('%s/public%s%s', $this->projectDir, self::PATH, $item->getThumb()));
        $this->delete($id);
    }
}
