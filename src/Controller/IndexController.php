<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
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
