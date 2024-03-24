<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Security\Voter\TaskVoter;
use App\Security\Voter\UserVoter;
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
        private UserRepository $userRepository,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/', name: 'list')]
    public function list(): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Merci de vous connecter!');
            return $this->redirectToRoute('login');
        }

        $tasks = $this->taskRepository->findByIsDoneFalse($this->getUser());
        $anonymous = $this->userRepository->findOneByUsername("anonymous");

        $tasksAnonymous = $this->taskRepository->findByIsDoneFalse($anonymous);

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
            'tasksAnonymous' => $tasksAnonymous,
        ]);
    }

    #[Route('/list-is-done', name: 'list_is_done')]
    public function listIsDone(): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Merci de vous connecter!');
            return $this->redirectToRoute('login');
        }

        $tasks = $this->taskRepository->findByIsDoneTrue($this->getUser());
        $anonymous = $this->userRepository->findOneByUsername("anonymous");

        $tasksAnonymous = $this->taskRepository->findByIsDoneTrue($anonymous);

        return $this->render('task/list_is_done.html.twig', [
            'tasks' => $tasks,
            'tasksAnonymous' => $tasksAnonymous,
        ]);
    }

    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Merci de vous connecter!');
            return $this->redirectToRoute('login');
        }

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

    #[Route('/{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Task $task, Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Merci de vous connecter!');
            return $this->redirectToRoute('login');
        }

        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        return $this->redirectToRoute('task_list');
    }


    #[Route('/{id}/delete', name: 'delete', methods: ["GET", "POST"])]
    public function deleteTask(
        Task $task
    ) {

        if (!$this->getUser()) {
            $this->addFlash('danger', 'Merci de vous connecter!');
            return $this->redirectToRoute('login');
        }

        $this->denyAccessUnlessGranted(TaskVoter::DELETE, $task);

        $this->manager->remove($task);
        $this->manager->flush();

        $this->addFlash('success', 'Votre tâche ' . '"' . $task->getTitle() . '"' . ' a été supprimée.');
        return $this->redirectToRoute('task_list');
    }
}
