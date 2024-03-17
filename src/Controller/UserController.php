<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/users', name: 'admin_users_')]

class UserController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $manager,
    ) {
    }

    #[Route('/', name: 'list', methods: ["GET"])]
    public function list(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted(UserVoter::READ, $this->getUser());

        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/create', name: 'create', methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted(UserVoter::NEW, $this->getUser());

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword(
                    $this->hasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $this->manager->persist($user);
                $this->manager->flush();

                $this->addFlash('success', "L'utilisateur a bien été ajouté.");
                return $this->redirectToRoute('user_list');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(
        User $user,
        Request $request
    ) {

        $this->denyAccessUnlessGranted(UserVoter::EDIT, $this->getUser());

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form->get('roles')->getData();

                $user->setRoles([$roles[0]])
                    ->setPassword(
                        $this->hasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );

                $this->manager->persist($user);
                $this->manager->flush();

                $this->addFlash('success', "L'utilisateur a bien été modifié.");
                return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
