<?php

namespace App\Controller;

use App\Form\UpdateTicketType;
use App\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateTicketController extends AbstractController
{
    #[Route('update/ticket', name: 'app_update')]
    public function access(Request $request): Response
        {
            if ($request->isMethod('POST')) {
            $id = $request->request->get('ticket_id');

            return $this->redirectToRoute('app_update_ticket', ['id' => $id]);
        }

        return $this->render('update_ticket/accesTicket.html.twig'); 
    }


    #[Route('/update/ticket/{id}', name: 'app_update_ticket')]
    public function index(int $id, TicketsRepository $ticketsRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = $ticketsRepository->find($id);
        if (!$ticket){
            return $this->redirectToRoute('app_update',['msg'=>"Le ticket demandé n'existe pas"]);
        }
        $form = $this->createForm(UpdateTicketType::class, $ticket,['session' => $request->getSession()]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_update',['msg'=>'Le ticket est bien mis à jour']);
}

        return $this->render('update_ticket/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'UpdateTicketController',
            'titre' => "Mise à jour d'un ticket",
        ]);
    }
}
