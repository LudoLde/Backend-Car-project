<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CarController extends AbstractController
{
    #[Route('/car/get_all', name: 'car.get', methods:['GET'])]
    public function get_all(CarRepository $repository, ): JsonResponse
    {
        $dataCars = [];
        $cars = $repository->findAll();

        foreach ($cars as $car) {
            $dataCars[] = [
                'id' => $car->getId(),
                'marque' => $car->getMarque(),
                'modele' => $car->getModele(),
                'annee_modele' => $car->getAnneeModele(),
                'boite_vitesse' => $car->getBoiteVitesse(),
                'carburant' => $car->getCarburant(),
                'image' => $car->getImage(),
                'createdAt' => $car->getCreatedAt()->format(\DateTime::ATOM)
            ];
            
        }
        return new JsonResponse($dataCars);
    }

    #[Route('/car/get_one/{id}', name: 'car.get_one', methods:['GET'])]
    public function get_one(CarRepository $repository, int $id): JsonResponse
    {
        $dataCar = [];
        $car = $repository->findOneBy(['id' => $id]);

        if ($car->getId() === $id) {
            $dataCar = [
                'id' => $car->getId(),
                'marque' => $car->getMarque(),
                'modele' => $car->getModele(),
                'annee_modele' => $car->getAnneeModele(),
                'boite_vitesse' => $car->getBoiteVitesse(),
                'carburant' => $car->getCarburant(),
                'image' => $car->getImage(),
                'createdAt' => $car->getCreatedAt()->format(\DateTime::ATOM)
            ];  
        }
        return new JsonResponse($dataCar);
    }

    #[Route('/car/edit/{id}', name: 'car.edit', methods:['GET', 'PUT'])]
    public function edit(CarRepository $repository, Request $request, EntityManagerInterface $manager, int $id, SluggerInterface $slugger): JsonResponse
    {
        $dataCar = json_decode($request->getContent(), true);

        $editCar = $repository->findOneBy(['id' => $id]);

        if($editCar->getId() === $id) {

        if(isset($dataCar['marque'])) 
        {
            $editCar->setMarque($dataCar['marque']);
        }
        if(isset($dataCar['modele'])) 
        {
            $editCar->setModele($dataCar['modele']);
        }
        if(isset($dataCar['annee_modele'])) 
        {
            $editCar->setAnneeModele($dataCar['annee_modele']);
        }
        if(isset($dataCar['boite_vitesse'])) 
        {
            $editCar->setBoiteVitesse($dataCar['boite_vitesse']);
        }
        if(isset($dataCar['boite_vitesse'])) 
        {
            $editCar->setBoiteVitesse($dataCar['boite_vitesse']);
        }
        if(isset($dataCar['carburant'])) 
        {
            $editCar->setCarburant($dataCar['carburant']);
        }
        
        if($request->files->has('image')){
            $imageFile = $request->files->get('image');
            $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $slugger->slug($originalFileName);
            $newFileName = $safeFileName.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_cars'),
                    $newFileName
                );
                $editCar->setImage($newFileName);
            } catch (FileException $ex) {
                return new JsonResponse(['error' => 'Failed to upload image']);
            }

        }

        $manager->persist($editCar);
    $manager->flush();

        return new JsonResponse('Car has been edited');
    }
}

#[Route('/car/create', name: 'car.create', methods:['POST'])]
public function create(EntityManagerInterface $manager, Request $request): JsonResponse
{

    
    $dataCar = json_decode($request->getContent(), true);

    $newCar = new Car();

    if(isset($dataCar['marque'])) 
    {
        $newCar->setMarque($dataCar['marque']);
    }
    if(isset($dataCar['modele'])) 
    {
        $newCar->setModele($dataCar['modele']);
    }
    if(isset($dataCar['annee_modele'])) 
    {
        $newCar->setAnneeModele($dataCar['annee_modele']);
    }
    if(isset($dataCar['boite_vitesse'])) 
    {
        $newCar->setBoiteVitesse($dataCar['boite_vitesse']);
    }
    if(isset($dataCar['boite_vitesse'])) 
    {
        $newCar->setBoiteVitesse($dataCar['boite_vitesse']);
    }
    if(isset($dataCar['carburant'])) 
    {
        $newCar->setCarburant($dataCar['carburant']);
    }
    if(isset($dataCar['image'])) 
    {
        $newCar->setCarburant($dataCar['image']);
    }

    $manager->persist($newCar);
    $manager->flush();

    return new JsonResponse('Car created');

    }

    #[Route('/car/delete/{id}', name: 'car.delete', methods:['DELETE'])]
    public function delete(CarRepository $repository, EntityManagerInterface $manager, int $id): JsonResponse
    {
        $deletedCar = $repository->findOneBy(['id' => $id]);

        if ($deletedCar->getId() === $id) {
        
         $manager->remove($deletedCar);
         $manager->flush();
    }
    return new JsonResponse('Car has been deleted !');

}
}
