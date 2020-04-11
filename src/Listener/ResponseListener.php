<?php


namespace App\Listener;


use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function __invoke(ResponseEvent $event)
    {
//        $response = $event->getResponse();
//        $content = $response->;
//        var_dump($content);
    }
}