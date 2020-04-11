<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param string $link
     * @param string $text
     * @throws Exception
     */
    public function saveText(string $link, string $text)
    {
        $item = $this->findOneBy(['link' => $link]);
        if (empty($item)) {
            throw new Exception('Не найдена страница');
        }
        $item->setText($text);
        $this->_em->persist($item);
        $this->_em->flush();
    }
}
