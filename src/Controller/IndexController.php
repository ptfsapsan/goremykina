<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    use ControllerTrait;
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'page' => $this->getPageRepository()->findOneBy(['link' => 'index']),
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash('warning', 'No such user');
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class);


        return $this->render('index/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error ? $error->getMessage() : null,
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('index/index.html.twig', [
            'page' => $this->getPageRepository()->findOneBy(['link' => 'about']),
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {

    }

    /**
     * @Route("/gallery", name="gallery")
     */
    public function gallery()
    {
        $category = $this->getGalleryCategoryRepository()
            ->findOneBy(['active' => 'yes'], ['id' => 'ASC']);

        return $this->redirectToRoute('gallery-category', ['id' => $category->getId()]);
    }

    /**
     * @Route("/gallery/{id}", name="gallery-category")
     * @param int $id
     * @return Response
     */
    public function galleryCategory(int $id)
    {
        return $this->render('index/gallery.html.twig', [
            'categories' => $this->getGalleryCategoryRepository()->findBy(['active' => 'yes']),
            'subcategories' => $this->getGallerySubcategoryRepository()
                ->findBy(['category_id' => $id, 'active' => 'yes']),
            'images' => $this->getGalleryImageRepository()->getByCategoryId($id),
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function contacts()
    {

    }

    /**
     * @Route("/methodical", name="methodical")
     */
    public function methodical()
    {

    }
}
