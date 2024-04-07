<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Security\Voter\TaskVoter;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/tasks', name: 'task_')]
#[IsGranted('ROLE_USER')]
class TaskController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $token,
        private TaskRepository $taskRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $manager,
    ) {
    }


    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $this->manager->persist($task);
            $this->manager->flush();

            $this->addFlash('success', 'Votre tâche a bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        $user = $this->getUser();
        $now = new \DateTimeImmutable();

        $tasks = $this->taskRepository->findByIsDoneFalse($user);

        // Fetch tasks for anonymous user if logged-in user is admin
        $tasksAnonymous = [];
        if ($user->getRoles()[0] === "ROLE_ADMIN") {
            $anonymous = $this->userRepository->findOneByUsername("anonymous");
            $tasksAnonymous = $this->taskRepository->findByIsDoneFalse($anonymous);
        }

        // Check if tasks are older than one month and add flash messages
        $this->addFlashForOldTasks($tasks, $now);
        $this->addFlashForOldTasks($tasksAnonymous, $now);

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
            'tasksAnonymous' => $tasksAnonymous,
        ]);
    }

    // Function to add flash messages for tasks older than one month
    private function addFlashForOldTasks(array $tasks, \DateTimeImmutable $now): void
    {
        foreach ($tasks as $task) {
            $createdAt = $task->getCreatedAt();
            $monthsDifference = $now->diff($createdAt)->format('%m');
            if ($monthsDifference >= 1) {
                $this->addFlash('danger', 'La tâche ' . $task->getTitle() . ' créée le ' . $createdAt->format('d-m-Y') . ' a plus d\'un mois! Merci de l\'a traitée ou de la supprimer.');
            }
        }
    }


    #[Route('/list-is-done', name: 'list_is_done', methods: ['GET'])]
    public function listIsDone(): Response
    {
        $tasks = $this->taskRepository->findByIsDoneTrue($this->getUser());
        $anonymous = $this->userRepository->findOneByUsername("anonymous");

        $tasksAnonymous = $this->taskRepository->findByIsDoneTrue($anonymous);

        return $this->render('task/list_is_done.html.twig', [
            'tasks' => $tasks,
            'tasksAnonymous' => $tasksAnonymous,
        ]);
    }


    #[Route('/{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUpdatedAt(new \DateTimeImmutable());

            $this->manager->persist($task);
            $this->manager->flush();

            $this->addFlash('success', 'Votre tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }


    #[Route('/{id}/toggle', name: 'toggle', methods: ["GET", "POST"])]
    public function toggleTask(
        Task $task
    ): Response {
        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

        $task->toggle(!$task->isIsDone());

        $task->setUpdatedAt(new \DateTimeImmutable());

        $this->manager->flush();

        if ($task->isIsDone() === false) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle()));
        } else {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        }

        return $this->redirectToRoute('task_list');
    }


    #[Route('/{id}/delete', name: 'delete', methods: ["GET", "POST"])]
    public function deleteTask(
        Task $task
    ): mixed {

        $this->denyAccessUnlessGranted(TaskVoter::DELETE, $task);
        $this->manager->remove($task);

        $this->manager->flush();

        $this->addFlash('success', 'Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');
        return $this->redirectToRoute('task_list');
    }
}
