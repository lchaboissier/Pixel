<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Game;


/**
 * Définie un prefix pour toutes les routes de ce controller
 * 
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/admin")
     */
    public function admin(): Response
    {
        return $this->render('game/admin.html.twig');
    }
    /**
     * @Route("/new")
     * 
     * On utilise l'injection de dépendance (Dependency Injection pour obtenir un objet EntityManager)
     */
    public function new(EntityManagerInterface $em): Response
    {
        // Créer une nouvelle entrée dans la table "game"
        $newGame = new Game();
        $newGame->setTitle("Super Mario Bros.");
        $newGame->setEnabled(true);

        $em->persist($newGame); // Prépare la requête, prêt à ajouter un nouvel objet en DB.

        $em->flush($newGame); // Exécute la registre

        // Ancienne méthode
        //$em = $this->getDoctrine()->getmanager();

        return $this->render('game/new.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
