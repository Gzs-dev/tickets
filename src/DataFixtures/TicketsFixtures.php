<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\States;
use App\Entity\Tickets;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class TicketsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Tickets();
        $product->setMailClient('Alphonse@xxx.fr');
        $product->setOpenDate (new DateTime('2026-08-10'));
        $product->setCloseDate(null);
        $product->setDescriptive('Vidéo de présentation figée');
        $product->setResponsable(null);
        $category = $manager->getRepository(Categories::class)->find(4);
        $state = $manager->getRepository(States::class)->find(1);
        $product->setCategory($category);
        $product->setState($state);  
        $manager->persist($product);
        
        $product = new Tickets();
        $product->setMailClient('Julien@xxx.fr');
        $product->setOpenDate (new DateTime('2026-07-10'));
        $product->setCloseDate(null);
        $product->setDescriptive("Impossible d'allumer l'imprimante");
        $product->setResponsable(null);
        $category = $manager->getRepository(Categories::class)->find(2);
        $state = $manager->getRepository(States::class)->find(1);
        $product->setCategory($category);
        $product->setState($state); 
        $manager->persist($product);

        $product = new Tickets();
        $product->setMailClient('Delphine@xxx.fr');
        $product->setOpenDate (new DateTime('2026-06-10'));
        $product->setCloseDate(null);
        $product->setDescriptive('La couleur du fond change à chaque retour de page');
        $product->setResponsable(null);
        $category = $manager->getRepository(Categories::class)->find(3);
        $state = $manager->getRepository(States::class)->find(1);
        $product->setCategory($category);
        $product->setState($state); 
        $manager->persist($product);

        $manager->flush();
    }
}
