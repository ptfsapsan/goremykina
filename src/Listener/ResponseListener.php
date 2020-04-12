<?php


namespace App\Listener;


use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function __invoke(ResponseEvent $event)
    {
//        $response = $event->getResponse()->setPublic();
//        var_dump($content);
    }
}