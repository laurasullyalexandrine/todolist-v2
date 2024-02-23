<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Security\Voter\TaskVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/tasks', name: 'task_')]
class TaskController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $token,
        private TaskRepository $taskRepository,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/', name: 'list')]
    public function list(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Merci de vous connecter.');
            return $this->redirectToRoute('login');
        }

        $tasks = $this->taskRepository->findAllTaskByUser($user);

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Merci de vous connecter.');
            return $this->redirectToRoute('login');
        }

        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $task->setUser($user);
                $this->manager->persist($task);
                $this->manager->flush();

                $this->addFlash('success', 'Votre tâche a bien été ajoutée.');
                return $this->redirectToRoute('task_list');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de votre tâche : ' . $e->getMessage());
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request): Response
    {

        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Merci de vous connecter.');
            return $this->redirectToRoute('login');
        }

        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

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
                return $this->redirect($request->headers->get('referer'));
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
        Task $task
    ): Response {

        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

        try {
            $task->toggle(!$task->isIsDone());
            $task->setUpdatedAt(new \DateTimeImmutable());

            $this->manager->flush();

            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
            return $this->redirectToRoute('task_list');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite lors de la modification de votre tâche  ' . '"' . $task->getTitle() . '"' . ' ' . $e->getMessage());
            return $this->redirect($request->headers->get('referer'));
        }
    }


    #[Route('/{id}/delete', name: 'delete', methods: ["GET", "POST"])]
    public function deleteTask(
        Request $request,
        Task $task
    ) {

        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

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
