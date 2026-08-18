<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $ticket = new Tickets();
        $form = $this->createForm(TicketType::class, $ticket);

        return $this->render('accueil/index.html.twig', [
            'form' => $form    
        ]);
    }
}
