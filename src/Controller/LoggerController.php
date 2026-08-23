<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class LoggerController extends AbstractController
{
    // #[IsGRanted('ROLE_ADMIN')]    
    #[Route('/logger', name: 'app_logger')]
    public function index(Request $request): Response
    {
        // Evite un accés direct sur la route logger
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('logger/index.html.twig');
    
    }
}


