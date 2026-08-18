<?php

namespace App\DataFixtures;

use App\Entity\States;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatesFixtures extends Fixture
{
    private $states = ["Nouveau", "Ouvert","Résolu", "Fermé"];
    public function load(ObjectManager $manager): void
    {
        
        foreach ($this->states as $state){
            $product = new States();
            $product->setName($state);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
