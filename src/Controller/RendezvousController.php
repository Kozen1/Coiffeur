<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\UserRepository;
use App\Repository\RendezvousRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/rendezvous')]
class RendezvousController extends AbstractController
{
    #[Route('/', name: 'app_rendezvous_index', methods: ['GET'])]
    public function index(RendezvousRepository $rendezvousRepository, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $userId = $this->getUser()->getId();
        $rendezvous = $doctrine->getRepository(Rendezvous::class)->findBy(['user' => $userId]);
        return $this->render('rendezvous/index.html.twig',[
            'rendezvous' => $rendezvous,
        ]);
    }

    #[Route('/new', name: 'app_rendezvous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RendezvousRepository $rendezvousRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $rendezvous = new Rendezvous();   
        $form = $this->createForm(RendezvousType::class, $rendezvous);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezvous->setUser($this->getUser());
            $rendezvousRepository->save($rendezvous, true);
    
            return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/new.html.twig', [
            'rendezvous' => $rendezvous,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_show', methods: ['GET'])]
    public function show(Rendezvous $rendezvous): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvous' => $rendezvous,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rendezvous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rendezvous $rendezvous, RendezvousRepository $rendezvousRepository): Response
    {
        $form = $this->createForm(RendezvousType::class, $rendezvous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezvousRepository->save($rendezvous, true);

            return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/edit.html.twig', [
            'rendezvous' => $rendezvous,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_delete', methods: ['POST'])]
    public function delete(Request $request, Rendezvous $rendezvous, RendezvousRepository $rendezvousRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvous->getId(), $request->request->get('_token'))) {
            $rendezvousRepository->remove($rendezvous, true);
        }

        return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
    }
}
