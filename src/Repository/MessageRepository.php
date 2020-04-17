<?php

namespace App\Repository;

use App\Entity\Message;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getWithPagination(int $onPage, int $page = 1)
    {
        return [
            'count' => count($this->findAll()),
            'items' => $this->findBy([], ['date' => 'DESC'], $onPage, ($page - 1) * $onPage),
        ];
    }

    /**
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(array $params)
    {
        $item = new Message();
        $item->setName($params['name']);
        $item->setEmail($params['email']);
        $item->setText($params['text']);
        $item->setDate(new DateTime());
        $this->_em->persist($item);
        $this->_em->flush();
    }
}
