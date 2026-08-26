<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request, UsersRepository $usersRepository): Response
    {
        $form = $this->createForm(LoginType::class);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
           $data = $form->getdata();
           $email = $data['mail'];
           $password = $data['mdp'];

           $user = $usersRepository->findOneBy(['mailUser' => $email]); 
           
           // Email inconnu
           if (!$user) {
                return $this->render('login/index.html.twig', [
                    'error' => 'Email inconnu',
                    'form' => $form->createView()
                ]);
            }

            // Mot de passe incorrect
            if ($user->getMdpUser() !== $password) {
                return $this->render('login/index.html.twig', [
                    'error' => 'Mot de passe incorrect',
                    'form' => $form->createView()
                ]);
            }

            // Connexion OK
            $session = $request->getSession();
            $session->set('role', $user->getRoleUser()[0]);

            return $this->redirectToRoute('app_logger');
        }

        // Afficher le formulaire login
        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'error' => null,
            ]);       
    }
}
