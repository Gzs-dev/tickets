<?php

namespace App\DataFixtures;

use app\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    private $users = array (
        ['mailUser'=>'ad00min@aaa.fr',
        'mdpUser'=>'Ti(k#e8La&',
        'roleUser'=>'ADMIN'
        ],
        ['mailUser'=>'st00aff@aaa.fr',
        'mdpUser'=>'Ck)l%83O]',
        'roleUser'=>'USER'
        ],
        ['mailUser'=>'st01aff@aaa.fr',
        'mdpUser'=>'Ms<1Uq[é',
        'roleUser'=>'USER'
        ],
    );


    public function load(ObjectManager $manager): void
    {
       
        foreach ($this->users as $user) {
            $product = new Users();
            $product->setMailUser($user['mailUser']);
            $product->setMdpUser($user['mdpUser']);
            $product->setRoleUser($user['roleUser']);

            $manager->persist($product);
        }

    $manager->flush();
    }
}
