<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/homepage', name: 'homepage', methods: ['GET'])]
    public function homepage(): Response
    {
        return $this->render('main/homepage.html.twig');
    }
}
