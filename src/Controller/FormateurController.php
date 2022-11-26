<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formateur')]
class FormateurController extends AbstractController
{
    #[Route('/', name: 'app_formateur_index', methods: ['GET'])]
    public function index(FormateurRepository $formateurRepository): Response
    {
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormateurRepository $formateurRepository): Response
    {
        $formateur = new Formateur();
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formateurRepository->save($formateur, true);

            return $this->redirectToRoute('app_formateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formateur/new.html.twig', [
            'formateur' => $formateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formateur_show', methods: ['GET'])]
    public function show(Formateur $formateur): Response
    {
        return $this->render('formateur/show.html.twig', [
            'formateur' => $formateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formateur $formateur, FormateurRepository $formateurRepository): Response
    {
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formateurRepository->save($formateur, true);

            return $this->redirectToRoute('app_formateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formateur/edit.html.twig', [
            'formateur' => $formateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formateur_delete', methods: ['POST'])]
    public function delete(Request $request, Formateur $formateur, FormateurRepository $formateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formateur->getId(), $request->request->get('_token'))) {
            $formateurRepository->remove($formateur, true);
        }

        return $this->redirectToRoute('app_formateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
