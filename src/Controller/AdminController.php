<?php

namespace App\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin/")
 */
class AdminController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("pages/{link}", name="admin-pages")
     * @param Request $request
     * @param string $link
     * @return Response
     * @throws Exception
     */
    public function pages(Request $request, string $link = 'index')
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $params = $request->request->all();
            switch ($params['act']) {
                case 'text':
                    $this->getPageRepository()->saveText($link, $params['text']);
                    break;
            }
            return $this->redirectToRoute('admin-pages', ['link' => $link]);
        }

        $pages = $this->getPageRepository()->findAll();
        $page = $this->getPageRepository()->findOneBy(['link' => $link]);

        return $this->render('admin/pages.html.twig', [
            'pages' => $pages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @Route("gallery-categories", name="admin-gallery-categories")
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function galleryCategories(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $act = $request->request->getAlpha('act');
            if ($act) {
                switch ($act) {
                    case 'add':
                        $this->getGalleryCategoryRepository()
                            ->add($request->request->get('title'));
                        break;
                }
            }
        } else {
            $act = $request->query->getAlpha('act');
            $id = $request->query->getInt('id');
            if ($act) {
                switch ($act) {
                    case 'delete':
                        $this->getGalleryCategoryRepository()->delete($id);
                        break;
                    case 'active':
                        $this->getGalleryCategoryRepository()->changeActive($id);
                        break;
                    case 'title':
                        $this->getGalleryCategoryRepository()
                            ->changeTitle($id, $request->query->get('title'));
                        break;
                }
                return $this->redirectToRoute('admin-gallery-categories');
            }
        }

        return $this->render('admin/gallery-categories.html.twig', [
            'categories' => $this->getGalleryCategoryRepository()->findAll(),
        ]);
    }

    /**
     * @Route("gallery-subcategories/{id}", name="admin-gallery-subcategories")
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function gallerySubcategories(int $id, Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $act = $request->request->getAlpha('act');
            if ($act) {
                switch ($act) {
                    case 'add':
                        $this->getGallerySubcategoryRepository()
                            ->add($id, $request->request->get('title'));
                        break;
                }
            }
        } else {
            $act = $request->query->getAlpha('act');
            $subcategoryId = $request->query->getInt('id');
            if ($act) {
                switch ($act) {
                    case 'delete':
                        $this->getGallerySubcategoryRepository()->delete($subcategoryId);
                        break;
                    case 'active':
                        $this->getGallerySubcategoryRepository()->changeActive($subcategoryId);
                        break;
                    case 'title':
                        $this->getGallerySubcategoryRepository()
                            ->changeTitle($subcategoryId, $request->query->get('title'));
                        break;
                }
                return $this->redirectToRoute('admin-gallery-subcategories', ['id' => $id]);
            }
        }

        return $this->render('admin/gallery-subcategories.html.twig', [
            'subcategories' => $this->getGallerySubcategoryRepository()->findAll(),
            'category' => $this->getGalleryCategoryRepository()->getById($id),
        ]);
    }

    /**
     * @Route("gallery-subcategory/{id}", name="admin-gallery-subcategory")
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function gallerySubcategory(int $id)
    {
        $subcategory = $this->getGallerySubcategoryRepository()->getById($id);
        $categoryId = $subcategory->getCategoryId();
        $category = $this->getGalleryCategoryRepository()->findOneBy(['id' => $categoryId]);

        return $this->render('admin/gallery-subcategory.html.twig', [
            'category' => $category,
            'subcategory' => $subcategory,
            'images' => $this->getGalleryImageRepository()->findBy(['subcategory_id' => $id]),
        ]);
    }

    /**
     * @Route("blog-themes", name="admin-blog-themes")
     */
    public function blogThemes()
    {
        return $this->render('admin/pages.html.twig', [
        ]);
    }

    /**
     * @Route("blog-articles", name="admin-blog-articles")
     */
    public function blogArticles()
    {
        return $this->render('admin/pages.html.twig', [
        ]);
    }

    /**
     * @Route("add-article", name="admin-add-article")
     */
    public function addArticle()
    {
        return $this->render('admin/pages.html.twig', [
        ]);
    }

    /**
     * @Route("blog-comments", name="admin-blog-comments")
     */
    public function blogComments()
    {
        return $this->render('admin/pages.html.twig', [
        ]);
    }

    /**
     * @Route("main-images", name="admin-main-images")
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function mainImages(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->getMainImageRepository()->saveImage($request->files->get('file'));
            return $this->redirectToRoute('admin-main-images');
        } else {
            $params = $request->query->all();
            if (isset($params['act'])) {
                $id = $request->query->getInt('id');
                switch ($params['act']) {
                    case 'delete':
                        $this->getMainImageRepository()->delete($id);
                        break;
                }
            }
        }

        return $this->render('admin/main-images.html.twig', [
            'images' => $this->getMainImageRepository()->findAll(),
        ]);
    }
}
