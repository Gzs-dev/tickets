<?php

namespace App\Controller;

use DateTime;
use App\Entity\Tickets;
use App\Form\TicketType;
use App\Repository\StatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request, EntityManagerInterface $entityManager, StatesRepository $stateRepository): Response
    {
        $ticket = new Tickets();
        $form = $this->createForm(TicketType::class, $ticket);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {          
            $ticket = $form->getData();
            $ticket->setOpenDate(new DateTime());
            $ticket->setCloseDate(null);
            $ticket->setState($stateRepository->find(1));
            $ticket->setResponsable(null);
            $entityManager->persist($ticket);
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('accueil/index.html.twig', [
            'form' => $form->createView(),
            'titre' => 'SAISIE TICKET',
        ]);
        
    }
}
