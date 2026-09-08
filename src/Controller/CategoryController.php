<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


final class CategoryController extends AbstractController
{
    private $msgDel = "";

    #[Route('/category', name: 'app_category')]
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
         // Evite un accés direct sur la route category si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $msgDel = $request->query->get('msgDel');
        $categories = $categoriesRepository->findAll();       
        return $this->render('category/index.html.twig', [
            'titre' => 'Modification des statuts',
            'categories'=> $categories,
            'msgDel'=> $msgDel,
        ]);
    }

      #[Route('/category/delete/{id}', name: 'app_category_delete')]
    public function delete(int $id, TicketsRepository $ticketsRepository, CategoriesRepository $categoriesRepository, EntityManagerInterface $entityManager, Request $request): Response
    {       
     // Evite un accés direct sur la route category/delete si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }    
    $categories = $categoriesRepository->find($id);  
        $count = $ticketsRepository->countTicketsByCategory($id); 
        if ($count > 0){
            $this->msgDel = "statut utilisé par des tickets, ne peut être supprimé";
            return $this->redirectToRoute ('app_category', ['msgDel'=> $this->msgDel]);
        }
        $entityManager->remove($categories);
        $entityManager->flush();
        $this->msgDel = "Etat sélectionné effacé";

        return $this->redirectToRoute ('app_category', ['msgDel'=> $this->msgDel]);
    }

    #[Route('/category/update/', name: 'app_category_update', methods:['POST'])]
    public function update(CategoriesRepository $categoriesRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
    
         // Evite un accés direct sur la route category/update si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $data = $request->request->all('categories'); 
        
        foreach ($data as $id => $newName) {
                $category = $categoriesRepository->find($id);
                if ($category) {
                    $category->setName($newName);
                    }
                }

        $entityManager->flush();        

        return $this->redirectToRoute('app_category');       
    }

    #[Route('/category/create/', name: 'app_category_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
         // Evite un accés direct sur la route category/create si pas connecté
        if (!$request->getsession()->get('role')) {
            return $this->redirectToRoute('app_accueil');
        }
        $name = $request->request->get('name')   ;
        $category = new Categories();
        $category->setName($name);

        $entityManager->persist($category);
        $entityManager->flush();

       return $this->redirectToRoute('app_category');
    }
}

