<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    private $categories = ["Incident","Panne","Evolution","Anomalie","Information"];
    public function load(ObjectManager $manager): void
    {
        
        foreach ($this->categories as $category) {
            $product = new Categories();
            $product->setName($category);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
