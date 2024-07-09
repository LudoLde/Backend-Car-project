<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class AuthController extends AbstractController
{

        #[Route('/api/login', name: 'api_login', methods: ['POST'])]
             public function login(?User $user): Response
              {
                 if (null === $user) {
                     return $this->json([
                         'message' => 'missing credentials',
                     ], Response::HTTP_UNAUTHORIZED);
                 }
        
                 $token = $user->getPassword(); // somehow create an API token for $user
        
                  return $this->json([
                     'message' => 'Welcome to your new controller!',
                     'path' => 'src/Controller/ApiLoginController.php',
                     'user'  => $user->getUserIdentifier(),
                     'token' => $token,
                  ]);
              }

      }
     