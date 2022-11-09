<?php 

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Symfony\Contracts\Translation\TranslatorInterface;
=======
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5

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
<<<<<<< HEAD
    public function admin(GameRepository $gameRepository, Request $request): Response
    {
        $p = $request->get('p', 1); // Page 1 par défaut
        $itemCount = 20;
        $search = $request->get('s', '');
        $entities = $gameRepository->findData($itemCount, $p, $search);
=======
    public function admin(GameRepository $GameRepository, Request $request): Response
    {
        $p = $request->get('p', 1); // Page 1 par défaut
        $itemCount = 5;
        $search = $request->get('s', '');
        $entities = $GameRepository->findData($itemCount, $p, $search);

>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5

        $pageCount = ceil($entities->count() / $itemCount);

        return $this->render('game/admin.html.twig', [
            'entities' => $entities,
            'pageCount' => max($pageCount, 1),
        ]);
    }

    /**
     * @Route("/new")
     * 
     * On utilise l'injection de dépendance (Dependency Injection) pour obtenir un objet EntityManager
     */
<<<<<<< HEAD
    public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator): Response
    {
        // Créer une nouvelle entrée dans la table "game"
        // $newGame = new Game;
        // $newGame->setTitle("Super Mario Bros.");
        // $newGame->setEnabled(true);

        // $em->persist($newGame); // Prepare la requête, prêt à ajouter un nouvel objet en db

        // $em->flush(); // Execute la requête

        // Ancienne methode
        //$em = $this->getDoctrine()->getManager();

        $entity = new Game;
        // Crée un formulaire à partir de la classe "GameType" et envois l'entity en tant que données 
=======
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

>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
        $form = $this->createForm(GameType::class, $entity);

        // Cherche des données _POST pour les envoyer au formulaire
        $form->handleRequest($request);

        // Test si le formulaire a bien été envoyé ET s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($entity);
            $em->flush();
<<<<<<< HEAD

            $this->addFlash('success', $translator->trans('game.new.success', [
                '%title%' => $entity->getTitle(),
            ]));

=======
            
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
            // Redirection vers la liste des jeux
            return $this->redirectToRoute('app_game_admin');
        }

        return $this->render('game/new.html.twig', [
<<<<<<< HEAD
            'form' => $form->createView(), // Créé la vue du formulaire
=======
            'form' => $form->createView(), // Crée la vue du formulaire
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
        ]);
    }

    /**
<<<<<<< HEAD
     * Route avec un paramètre "id", "\d+" indique que l'id est un nombre entier de 1 ou plusieurs chiffres
=======
     * Route avec un paramètre "id" "\d+" indique que l'id est un nombre entier de 1 ou plusieurs chiffres
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
     * Grâce au "Param Converter", Sf va récupérer l'objet Game par rapport au paramètre id
     * 
     * @Route("/{id}/edit", requirements={"id": "\d+"})
     */
<<<<<<< HEAD
    public function edit(EntityManagerInterface $em, Request $request, Game $entity, TranslatorInterface $translator): Response 
=======
    public function edit(EntityManagerInterface $em, Request $request, Game $entity): Response
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
    {
        $form = $this->createForm(GameType::class, $entity);

        $form->handleRequest($request);

<<<<<<< HEAD
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('info', $translator->trans('game.edit.success', [
                '%title%' => $entity->getTitle(),
            ]));

            return $this->redirectToRoute('app_game_admin');
        }

=======
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('app_game_admin');
        }


>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }

    /**
<<<<<<< HEAD
     * @Route("/{id}/delete", requirements={"id":"\d+"})
     */
    public function delete(EntityManagerInterface $em, Request $request, Game $entity, TranslatorInterface $translator): Response 
=======
     * @Route("/{id}/delete", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $em, Request $request, Game $entity): Response
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
    {
        if ($this->isCsrfTokenValid('delete_game_'.$entity->getId(), $request->get('token'))) {
            $em->remove($entity);
            $em->flush();

<<<<<<< HEAD
            $this->addFlash('danger', $translator->trans('game.delete.success', [
                '%title%' => $entity->getTitle(),
            ]));

            return $this->redirectToRoute('app_game_admin');
=======
            return $this->redirectToRoute('app_game_delete');
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
        }
        return $this->render('game/delete.html.twig', [
            'entity' => $entity,
        ]);
    }
}