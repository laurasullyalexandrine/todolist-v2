<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks', name: 'task_')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(TaskRepository $taskRepository): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }
}
