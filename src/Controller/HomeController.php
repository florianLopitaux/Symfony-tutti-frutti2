<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Service\DiscogsAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, DiscogsAccess $api, string $fruit): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/home/search', name: 'app_home_search', methods: ['GET', 'POST'])]
    public function search(Request $request, DiscogsAccess $api): Response
    {
        $releases = $api->getSearchRelease(
            $request->request->get("fruit_search"));

        return $this->render('home/index.html.twig', [
            'releases' => $releases
        ]);
    }
}
