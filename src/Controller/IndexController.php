<?php

namespace App\Controller;

use App\Form\ContactsType;
use App\Form\LoginType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Redis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    use RepositoryTrait;

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
        return $this->render('index/blog.html.twig', [
            'mainImage' => $this->getMainImage(),

        ]);
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
     * @Route("/methodical", name="methodical")
     */
    public function methodical()
    {
        return $this->render('index/methodical.html.twig', [
            'docs' => $this->getMethodicalDocRepository()->findAll(),
            'docsDir' => $this->getMethodicalDocRepository()::PATH,
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/game-room", name="game-room")
     */
    public function gameRoom()
    {
        return $this->render('index/game-room.html.twig', [
            'categories' => $this->getGameRoomCategoryRepository()->findBy(['active' => 'yes']),
            'iconDir' => $this->getGameRoomCategoryRepository()::PATH,
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/game-room-category/{id}", name="game-room-category")
     * @param int $id
     * @return Response
     */
    public function gameRoomCategory(int $id)
    {
        return $this->render('index/game-room-category.html.twig', [
            'category' => $this->getGameRoomCategoryRepository()->findOneBy(['id' => $id]),
            'imageDir' => $this->getGameRoomImageRepository()::PATH,
            'images' => $this->getGameRoomImageRepository()->findBy(['category_id' => $id]),
            'mainImage' => $this->getMainImage(),
        ]);
    }

    /**
     * @Route("/contacts", name="contacts")
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function contacts(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $params = $request->request->all()['contacts'];
            $this->getMessageRepository()->add($params);
            return $this->redirectToRoute('contacts');
        }
        $form = $this->createForm(ContactsType::class);

        return $this->render('index/contacts.html.twig', [
            'form' => $form->createView(),
            'mainImage' => $this->getMainImage(),
        ]);
    }

}
