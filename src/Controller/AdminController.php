<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin/")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("pages", name="admin-pages")
     */
    public function index()
    {
        return $this->render('admin/pages.html.twig', [
        ]);
    }
    /**
     * @Route("gallery-sections", name="admin-gallery-sections")
     */
    public function gallerySections()
    {
        return $this->render('admin/pages.html.twig', [
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
}
