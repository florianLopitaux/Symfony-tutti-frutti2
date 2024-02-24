<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // check if the user is logged to redirect it
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_search');

        } else {
            return $this->render('pages/home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
