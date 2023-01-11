<?php

namespace App\Controller;

use App\Address\AdressApiInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $name = "David";

        // Retourner le rendu d'une vue Twig
        // On envoie la valeur $name dans la vue
        return $this->render('app/homepage.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/address')]
    public function address(Request $request, AddressApiInterface $addressApi): JsonResponse
    {
        $search = $request->get('search', '');
        $result = $addressApi->searchAddress($search);

        return new JsonResponse($result);
    }
}