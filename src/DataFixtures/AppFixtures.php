<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
            $car = new Car();
            $car->setMarque('Hyundai')
                ->setModele('i20')
                ->setAnneeModele(mt_rand(2020, 2024))
                ->setBoiteVitesse(mt_rand(0,1)== 1 ? 'Automatique': 'Manuelle')
                ->setCarburant(mt_rand(0,1)== 1 ? 'Essence': 'Diesel');
         $manager->persist($car);
        }
        
        $manager->flush();
    }
}
