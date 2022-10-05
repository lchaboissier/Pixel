<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;

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
    public function admin(GameRepository $GameRepository): Response
    {
        $entities = $GameRepository->findAll();
        return $this->render('game/admin.html.twig', [
            'entities' => $entities
        ]);
    }
    
    /**
     * @Route("/new")
     * 
     * On utilise l'injection de dépendance (Dependency Injection pour obtenir un objet EntityManager)
     */
    public function new(EntityManagerInterface $em): Response
    {
        // Créer une nouvelle entrée dans la table "game"
        // $newGame = new Game();
        // $newGame->setTitle("Super Mario Bros.");
        // $newGame->setEnabled(true);

        // $em->persist($newGame); // Prépare la requête, prêt à ajouter un nouvel objet en DB.

        // $em->flush($newGame); // Exécute la registre

        // Ancienne méthode
        //$em = $this->getDoctrine()->getmanager();

        // Crée un formulaire à partir de la classe "GameType" et envoie l'entity en tant que données
        $entity = new Game;
        $form = $this->createForm(GameType::class, $entity);

        return $this->render('game/new.html.twig', [
            'form' => $form->createView(), // Crée la vue du formulaire
        ]);
    }
}
