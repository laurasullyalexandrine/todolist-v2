<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MainController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $token
    ) {
    }
    
    #[Route('/homepage', name: 'homepage')]
    public function homepage(TaskRepository $taskRepository): Response
    {
        $user = $this->token->getToken()->getUser();
        $tasks = $taskRepository->findAllTaskByUser($user);;
        return $this->render('main/homepage.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
