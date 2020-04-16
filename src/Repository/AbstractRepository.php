<?php


namespace App\Repository;


use App\Model\Tools;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AbstractRepository extends ServiceEntityRepository
{
    protected $container;
    protected $entity;
    protected $projectDir;

    public function __construct(ManagerRegistry $registry, ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->projectDir = $this->container->get('kernel')->getProjectDir();
        parent::__construct($registry, $this->entity);
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

    /**
     * @param string $ext
     * @return string
     * @throws NonUniqueResultException
     */
    protected function getImageFileName(string $ext)
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

    /**
     * @param string $ext
     * @return string
     * @throws NonUniqueResultException
     */
    protected function getDocFileName(string $ext)
    {
        $name = sprintf('%s.%s', Tools::generateDigitCode(6), $ext);
        $query = $this->createQueryBuilder('gi')
            ->select('gi')
            ->where('gi.file_name = :name')
            ->setParameter('name', $name);
        $item = $query->getQuery()->getOneOrNullResult();
        if ($item) {
            return $this->getDocFileName($ext);
        }

        return $name;
    }

}