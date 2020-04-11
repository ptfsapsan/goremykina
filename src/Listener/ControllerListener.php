<?php


namespace App\Listener;


use App\Controller\IndexController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class ControllerListener
{

    public function __invoke(ControllerEvent $event)
    {
//        $controller = $event->getController();
//        if (!is_array($controller)) {
//            return;
//        }
//        /** @var AbstractController $controllerObject */
//        $controllerObject = $controller[0];
//        if ($controllerObject instanceof IndexController) {
//            $mainImage = $controllerObject->getMainImageRepository()->findOneBy(['active' => 'yes']);
//            $request = $event->getRequest()->query->all();
//        }

    }
}