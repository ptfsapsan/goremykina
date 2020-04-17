<?php


namespace App\Listener;


use App\Entity\Requests;
use App\Repository\RequestsRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class Listener
{
    /** @var Registry|object|null */
    private $doctrine;
    private $isTooManyRequests = false;

    public function __construct(ContainerInterface $container)
    {
        $this->doctrine = $container->get('doctrine');
    }

    /**
     * @param RequestEvent $event
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        /** @var RequestsRepository $requestRepository */
        $requestRepository = $this->doctrine->getRepository(Requests::class);
        $requestRepository->addNew($request);
        $this->isTooManyRequests = !$requestRepository->isAllowed($request);
    }

    /**
     * @param ResponseEvent $event
     * @throws Exception
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        if ($this->isTooManyRequests) {
            /** @var RequestsRepository $requestRepository */
            $requestRepository = $this->doctrine->getRepository(Requests::class);
            $requestRepository->removeOld();
            $response = new RedirectResponse('/too-many-requests');
            $response->send();
        }
    }

}