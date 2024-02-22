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

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            return $this->extractFruitPost($request);
        }

        return $this->render('home/index.html.twig', []);
    }

    #[Route('/{fruit}', name: 'app_home_search', methods: ['GET', 'POST'])]
    public function search(Request $request, DiscogsAccess $api, string $fruit): Response {
        if ($request->getMethod() === 'POST') {
            return $this->extractFruitPost($request);
        }

        $releases = $api->getSearchRelease($fruit);

        return $this->render('home/index.html.twig', [
            'releases' => $releases
        ]);
    }


    private function extractFruitPost(Request $request): Response {
        $fruit = $request->request->get("fruit_search");

        return $this->redirectToRoute('app_home_search',
            ['fruit' => $fruit],
            Response::HTTP_SEE_OTHER);
    }
}
