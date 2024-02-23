<?php

namespace App\Controller;

use App\Service\DiscogsAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            return $this->extractFruitPost($request);
        }

        return $this->render('pages/search/index.html.twig', []);
    }

    #[Route('/{fruit}', name: 'app_search_fruit', methods: ['GET', 'POST'])]
    public function search(Request $request, DiscogsAccess $api, string $fruit): Response {
        if ($request->getMethod() === 'POST') {
            return $this->extractFruitPost($request);
        }

        $releases = $api->getSearchRelease($fruit);


        return $this->render('pages/search/index.html.twig', [
            'releases' => $releases,
            'fruit' => $fruit
        ]);
    }


    private function extractFruitPost(Request $request): Response {
        $fruit = $request->request->get("fruit_search");

        if ($fruit == null) {
            return $this->redirectToRoute('app_search',
                [],
                Response::HTTP_SEE_OTHER);

        } else {
            return $this->redirectToRoute('app_search_fruit',
                ['fruit' => $fruit],
                Response::HTTP_SEE_OTHER);
        }
    }
}
