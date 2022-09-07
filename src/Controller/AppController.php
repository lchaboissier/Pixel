<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * Annotation pour indiquer la route de cette page
     * 
     * @Route("/")
     */
    public function homepage(): Response
    {
        // Cette méthode correspond à une page, elle doit toujours retourner un objet Response

        // return new Response('Hello World');
        // Retourner le rendu d'une vue Twig
        return $this->render('app/homepage.html.twig');
    }
}