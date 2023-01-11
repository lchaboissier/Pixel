<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Security\Voter\SupportVoter;
use App\Repository\SupportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/support')]
#[IsGranted("ROLE_USER")]
class SupportController extends AbstractController
{
    #[Route('/', name: 'app_support_index', methods: ['GET'])]
    public function index(SupportRepository $supportRepository, Request $request): Response
    {
        $author = $this->getUser();
        if ($this->isGranted('ROLE_ADMIN')) { // Affiche tous les jeux si l'user est admin
            $author = null;
        }

        $p = $request->get('p', 1); // Page 1 par défaut
        $itemCount = 20;
        $search = $request->get('s', '');
        $supports = $supportRepository->findData($itemCount, $p, $search);

        $pageCount = ceil($supports->count() / $itemCount);

        return $this->render('support/index.html.twig', [
            // 'supports' => $supportRepository->findAll(),
            'supports' => $supports,
            'pageCount' => max($pageCount, 1),
        ]);
    }

    #[Route('/new', name: 'app_support_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")]
    public function new(Request $request, SupportRepository $supportRepository): Response
    {

        $support = new Support();
        $this->denyAccessUnlessGranted(SupportVoter::NEW, $support);
        $support->setAuthor($this->getUser());
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportRepository->save($support, true);

            return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('support/new.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_support_show', methods: ['GET'])]
    public function show(Support $support): Response
    {
        return $this->render('support/show.html.twig', [
            'support' => $support,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_support_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")]
    public function edit(Request $request, Support $support, SupportRepository $supportRepository): Response
    {
        // Crée une erreur si l'user n'a pas le droit de modifier le jeu
        $this->denyAccessUnlessGranted(SupportVoter::EDIT, $support);

        if ($support->getAuthor() === null)
        {
            $support->setAuthor($this->getUser());
        }

        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportRepository->save($support, true);

            return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('support/edit.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_support_delete', methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function delete(Request $request, Support $support, SupportRepository $supportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$support->getId(), $request->request->get('_token'))) {
            $supportRepository->remove($support, true);
        }

        return $this->redirectToRoute('app_support_index', [], Response::HTTP_SEE_OTHER);
    }
}
