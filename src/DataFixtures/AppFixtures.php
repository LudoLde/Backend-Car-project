<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($faker->word());
         $manager->persist($user);
        }
        
        $manager->flush();
    }
}
