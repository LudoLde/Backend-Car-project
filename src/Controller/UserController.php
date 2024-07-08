<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/car/get_user/{id}', name: 'car.get_user', methods:['GET'])]
    public function get_one(UserRepository $repository, int $id): JsonResponse
    {
        $dataUser = [];
        $user = $repository->findOneBy(['id' => $id]);
    
        if ($user->getId() === $id) {
            $dataUser = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]; 
        }
        return new JsonResponse($dataUser);
    }
  
}
