<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/ajax/")
 */
class AjaxController extends AbstractController
{
    use ControllerTrait;
    /**
     * @Route("get-index-init")
     * @return JsonResponse
     */
    public function getIndexInit()
    {
        $month = (int)date('m');
        $path = sprintf(
            'images/background/%s/*.*',
            $month >= 3 && $month <= 5 ? 'spring'
                : ($month >= 6 && $month <= 8 ? 'summer'
                : ($month >= 9 && $month <= 11 ? 'autumn' : 'winter'))
        );
        $images = glob($path, GLOB_NOSORT);
        shuffle($images);
        $mainImage = $this->getMainImage();

        return $this->json([
            'backgroundImages' => $images,
            'mainImage' => sprintf('/images/main-images/%s', $mainImage->getBig()),
        ]);
    }

    /**
     * @Route("get-gallery-images")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getGalleryImages(Request $request, SerializerInterface $serializer)
    {
        $subcategoryId = $request->request->getInt('subcategoryId');
        $images = $this->getGalleryImageRepository()->findBy(['subcategory_id' => $subcategoryId]);

        return $this->json(json_decode($serializer->serialize($images, 'json'), true));
    }

    /**
     * @Route("upload-gallery-image")
     * @param Request $request
     * @return Response
     */
    public function uploadGalleryImage(Request $request)
    {
        $file = $request->files->get('file');
        $categoryId = $request->request->getInt('categoryId');
        $subcategoryId = $request->request->getInt('subcategoryId');
        try {
            $this->getGalleryImageRepository()->saveFile($categoryId, $subcategoryId, $file);
        } catch (Exception $e) {
            return $this->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'status' => true,
        ]);
    }

    /**
     * @Route("delete-gallery-image")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function deleteGalleryImage(Request $request)
    {
        $id = $request->request->getInt('id');
        $this->getGalleryImageRepository()->delete($id);

        return new Response();
    }

    public function getPageFiles()
    {
        return new Response();
    }

}
