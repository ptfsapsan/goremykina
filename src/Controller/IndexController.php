<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $form = $this->createForm(LoginType::class);

        if ($request->isMethod(Request::METHOD_POST)) {

        }

        return $this->render('index/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
