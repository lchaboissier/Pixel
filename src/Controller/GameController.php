<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;

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
    public function admin(GameRepository $GameRepository, Request $request): Response
    {
        $p = $request->get('p', 1); // Page 1 par défaut
        $itemCount = 5;
        $search = $request->get('s', '');
        $entities = $GameRepository->findData($itemCount, $p, $search);


        $pageCount = ceil($entities->count() / $itemCount);

        return $this->render('game/admin.html.twig', [
            'entities' => $entities,
            'pageCount' => max($pageCount, 1),
        ]);
    }
    
    /**
     * @Route("/new")
     * 
     * On utilise l'injection de dépendance (Dependency Injection pour obtenir un objet EntityManager)
     */
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        // Créer une nouvelle entrée dans la table "game"
        // $newGame = new Game();
        // $newGame->setTitle("Super Mario Bros.");
        // $newGame->setEnabled(true);

        // $em->persist($newGame); // Prépare la requête, prêt à ajouter un nouvel objet en DB.

        // $em->flush($newGame); // Exécute la registre

        // Ancienne méthode
        //$em = $this->getDoctrine()->getmanager();
        
        $entity = new Game;
        // Crée un formulaire à partir de la classe "GameType" et envoie l'entity en tant que données

        $form = $this->createForm(GameType::class, $entity);

        // Cherche des données _POST pour les envoyer au formulaire
        $form->handleRequest($request);

        // Test si le formulaire a bien été envoyé ET s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($entity);
            $em->flush();
            
            // Redirection vers la liste des jeux
            return $this->redirectToRoute('app_game_admin');
        }

        return $this->render('game/new.html.twig', [
            'form' => $form->createView(), // Crée la vue du formulaire
        ]);
    }

    /**
     * Route avec un paramètre "id" "\d+" indique que l'id est un nombre entier de 1 ou plusieurs chiffres
     * Grâce au "Param Converter", Sf va récupérer l'objet Game par rapport au paramètre id
     * 
     * @Route("/{id}/edit", requirements={"id": "\d+"})
     */
    public function edit(EntityManagerInterface $em, Request $request, Game $entity): Response
    {
        $form = $this->createForm(GameType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('app_game_admin');
        }


        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id}/delete", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $em, Request $request, Game $entity): Response
    {
        if ($this->isCsrfTokenValid('delete_game_'.$entity->getId(), $request->get('token'))) {
            $em->remove($entity);
            $em->flush();

            return $this->redirectToRoute('app_game_delete');
        }
        return $this->render('game/delete.html.twig', [
            'entity' => $entity,
        ]);
    }
}