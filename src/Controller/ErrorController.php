<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    use RepositoryTrait;

    /**
     * @Route("/too-many-requests")
     */
    public function tooManyRequests()
    {
        return $this->render('error/too-many-requests.html.twig', [
            'mainImage' => $this->getMainImage(),
        ]);
    }
}
