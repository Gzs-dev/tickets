<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear(); 

        return $this->redirectToRoute('app_accueil');
    }
}
