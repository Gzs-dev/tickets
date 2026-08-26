<?php

namespace App\Controller;

use App\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReadTicketsController extends AbstractController
{
    #[Route('/read/tickets', name: 'app_read_tickets')]
    public function index(TicketsRepository $ticketsRepository): Response
    {
        $tickets = $ticketsRepository->findAll();
        return $this->render('read_tickets/index.html.twig', [
        'tickets' => $tickets
    ]);
}

     
}
