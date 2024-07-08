<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class AuthController extends AbstractController
{

      #[Route("/api/login", name:"login", methods:["GET", "POST"])]  
      public function login(Request $request, UserRepository $repository): Response
      {
          $data = json_decode($request->getContent(), true);
          $user = $this->$repository->findOneBy(['email' => $data['email']]);
  
          if(!$user){
                return new Response('user non reconnu ou identifiants incorrects');
          }
  
          return new Response('User logged in successfully', 200);

      }


    /**
     * @Route("/logout", name="logout", methods={"POST"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
