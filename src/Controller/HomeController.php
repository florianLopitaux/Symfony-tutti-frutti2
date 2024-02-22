<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Service\DiscogsAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
            'releases' => $releases,
            'fruit' => $fruit
        ]);
    }


    private function extractFruitPost(Request $request): Response {
        $fruit = $request->request->get("fruit_search");

        if($fruit == null) {
            return $this->redirectToRoute('app_home',
                [],
                Response::HTTP_SEE_OTHER);
        }
        else {
            return $this->redirectToRoute('app_home_search',
                ['fruit' => $fruit],
                Response::HTTP_SEE_OTHER);
        }
    }
}
