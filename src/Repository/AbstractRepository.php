<?php


namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AbstractRepository extends ServiceEntityRepository
{
    protected $container;

    public function __construct(ManagerRegistry $registry, $entity, ContainerInterface $container = null)
    {
        $this->container = $container;
        parent::__construct($registry, $entity);
    }

    /**
     * @param int $id
     * @return object|null
     * @throws Exception
     */
    public function getById(int $id)
    {
        $item = $this->find($id);
        if (!$item) {
            throw new Exception('Объект не найден');
        }

        return $item;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id)
    {
        $item = $this->getById($id);
        $this->_em->remove($item);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function changeActive(int $id)
    {
        $item = $this->getById($id);
        $active = $item->getActive() == 'yes' ? 'no' : 'yes';
        $item->setActive($active);
        $this->_em->persist($item);
        $this->_em->flush();
    }

}