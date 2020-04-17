<?php

namespace App\Repository;

use App\Entity\Requests;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Requests|null find($id, $lockMode = null, $lockVersion = null)
 * @method Requests|null findOneBy(array $criteria, array $orderBy = null)
 * @method Requests[]    findAll()
 * @method Requests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestsRepository extends ServiceEntityRepository
{
    private const QUERY_RESTRICTION = [
        '/login' => [
            'limit' => 2,
            'secs' => 60,
        ],
        '/contacts' => [
            'limit' => 2,
            'secs' => 60,
        ],
    ];


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requests::class);
    }
    
    private static function isForVerify(Request $request)
    {
        return $request->isMethod(Request::METHOD_POST)
            && in_array($request->getRequestUri(), array_keys(self::QUERY_RESTRICTION));
    }

    /**
     * @param Request $request
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addNew(Request $request)
    {
        $uri = $request->getRequestUri();
        if (self::isForVerify($request)) {
            $item = new Requests();
            $item->setUri($uri);
            $item->setIp($request->getClientIp());
            $item->setTime(new DateTime());
            $this->_em->persist($item);
            $this->_em->flush();
        }
    }

    /**
     * @param Request $request
     * @return bool
     * @throws Exception
     */
    public function isAllowed(Request $request)
    {
        $uri = $request->getRequestUri();
        if (self::isForVerify($request)) {
            $sec = self::QUERY_RESTRICTION[$uri]['secs'];
            $qb = $this->createQueryBuilder('t');
            $query = $qb
                ->where('t.uri = :uri')
                ->andWhere('t.time > :time')
                ->andWhere('t.ip = :ip')
                ->setParameters([
                    'uri' => $uri,
                    'time' => new DateTime('-' . $sec . 'sec'),
                    'ip' => $request->getClientIp(),
                ]);
            $requests = $query->getQuery()->getArrayResult();

            return self::QUERY_RESTRICTION[$uri]['limit'] >= count($requests);
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function removeOld()
    {
        $max = 0;
        foreach (self::QUERY_RESTRICTION as $item) {
            $max = max($max, $item['secs']);
        }
        $max++;
        $minDateTime = new DateTime(sprintf('-%dsec', $max));

        $qb = $this->createQueryBuilder('t');
        $qb->delete()
            ->where('t.time < :time')
            ->setParameter('time', $minDateTime->format('Y-m-d H:i:s'))
            ->getQuery()
            ->execute();
    }
}
