<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/")
 */
class AjaxController extends AbstractController
{
    /**
     * @Route("get-background-image")
     * @param Request $request
     * @return JsonResponse
     */
    public function getBackgroundImage(Request $request)
    {
        $currentImage = $request->request->get('backgroundImage');
        $month = (int)date('m');
        $path = sprintf(
            'images/background/%s/*.*',
            $month >= 3 && $month <= 5 ? 'spring'
                : ($month >= 6 && $month <= 8 ? 'summer'
                : ($month >= 9 && $month <= 11 ? 'autumn' : 'winter'))
        );
        $images = glob($path, GLOB_NOSORT);
        $index = (int) array_search($currentImage, $images);
        $index = $index >= count($images) - 1 ? 0 : $index + 1;

        return $this->json(['image' => $images[$index]]);
    }
}
