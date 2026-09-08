<?php

namespace App\Controller;

use App\Entity\States;
use App\Repository\StatesRepository;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class StatesController extends AbstractController
{
    private $msgDel = "";

    #[Route('/states', name: 'app_states')]
    public function Read(StatesRepository $statesRepository, Request $request): Response
    {        
         // Evite un accés direct sur la route states si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $msgDel = $request->query->get('msgDel');
        $states = $statesRepository->findAll();       
        return $this->render('states/index.html.twig', [
            'titre' => 'Modification des états',
            'states'=> $states,
            'msgDel'=> $msgDel,
        ]);
    }

     #[Route('/states/delete/{id}', name: 'app_states_delete')]
    public function delete(int $id, TicketsRepository $ticketsRepository, StatesRepository $statesRepository, EntityManagerInterface $entityManager, Request $request): Response
    {       
         // Evite un accés direct sur la route states/delete si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $states = $statesRepository->find($id);  
        $count = $ticketsRepository->countTicketsByState($id); 
        if ($count > 0){
            $this->msgDel = "Etat utilisé par des tickets, ne peut être supprimé";
            return $this->redirectToRoute ('app_states', ['msgDel'=> $this->msgDel]);
        }
        $entityManager->remove($states);
        $entityManager->flush();
        $this->msgDel = "Etat sélectionné effacé";

        return $this->redirectToRoute ('app_states', ['msgDel'=> $this->msgDel]);
    }

    #[Route('/states/update/', name: 'app_states_update', methods:['POST'])]
    public function update(StatesRepository $statesRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
    
         // Evite un accés direct sur la route states/update si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $data = $request->request->all('states'); 
        
        foreach ($data as $id => $newName) {
                $state = $statesRepository->find($id);
                if ($state) {
                    $state->setName($newName);
                    }
                }

        $entityManager->flush();        

        return $this->redirectToRoute('app_states');       
    }

    #[Route('/states/create/', name: 'app_states_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
         // Evite un accés direct sur la route state/create si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $name = $request->request->get('name')   ;
        $state = new States();
        $state->setName($name);

        $entityManager->persist($state);
        $entityManager->flush();

       return $this->redirectToRoute('app_states');
    }
}
