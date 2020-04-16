<?php

namespace App\Repository;

use App\Entity\MethodicalDoc;
use App\Model\Tools;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method MethodicalDoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method MethodicalDoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method MethodicalDoc[]    findAll()
 * @method MethodicalDoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MethodicalDocRepository extends AbstractRepository
{
    protected $entity = MethodicalDoc::class;
    public const PATH = '/docs/methodical-docs/';

    /**
     * @param UploadedFile $file
     * @param string $title
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function saveDoc(UploadedFile $file, string $title)
    {
        Tools::verifyDocFile($file);
        $dir = sprintf('%s/public%s', $this->projectDir, self::PATH);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->getClientOriginalExtension();
        $fileName = $this->getDocFileName($ext);
        copy($file->getRealPath(), $dir . $fileName);

        $item = new MethodicalDoc();
        $item->setTitle($title);
        $item->setFileName($fileName);
        $item->setMime($file->getMimeType());
        $this->_em->persist($item);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function deleteDoc(int $id)
    {
        /** @var MethodicalDoc $item */
        $item = $this->getById($id);
        unlink(sprintf('%s/public%s%s', $this->projectDir, self::PATH, $item->getFileName()));
        $this->delete($id);
    }
}
