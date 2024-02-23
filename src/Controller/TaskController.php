<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tasks', name: 'task_')]
class TaskController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/', name: 'list')]
    public function list(): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $this->taskRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $this->manager->persist($task);
                $this->manager->flush();

                $this->addFlash('success', 'La tâche a été bien été ajoutée.');
                return $this->redirectToRoute('task_list');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de votre tâche : ' . $e->getMessage());
                return $this->redirect($request->headers->get('referer'));
            }

            return $this->render('task/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request): Response
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->manager->persist($task);
                $this->manager->flush();

                $this->addFlash('success', 'La tâche a bien été modifiée.');
                return $this->redirectToRoute('task_list');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur s\'est produite lors de la modification de votre tâche  ' . '"' . $task->getTitle() . '"' . ' ' . $e->getMessage());
            }
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }


    #[Route('/{id}/toggle', name: 'toggle', methods: ["GET", "POST"])]
    public function toggleTask(
        Request $request,
        Task $task): Response
    {
        try {
            $task->toggle(!$task->isIsDone());
            $this->manager->flush();
    
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
    
            return $this->redirectToRoute('task_list');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite lors de la modification de votre tâche  ' . '"' . $task->getTitle() . '"' . ' ' . $e->getMessage());
            return $this->redirect($request->headers->get('referer'));
        }
    }


    #[Route('/{id}/delete', name: 'task_delete', methods: ["GET", "POST"])]
    public function deleteTask(
        Request $request,
        Task $task
    ) {
        try {
            if (!$task) {
                throw $this->createNotFoundException('Figure non trouvée.');
            }

            $this->manager->remove($task);
            $this->manager->flush();

            $this->addFlash('success', 'Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');
            return $this->redirectToRoute('task_list');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite lors de la suppression de votre tâche  ' . '"' . $task->getTitle() . '"' . ' ' . $e->getMessage());
            return $this->redirect($request->headers->get('referer'));
        }
    }
}