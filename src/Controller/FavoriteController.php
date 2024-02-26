<?php

namespace App\Controller;

use App\Entity\Music;
use App\Repository\MusicRepository;
use App\Repository\UserRepository;
use App\Service\DiscogsAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/favorite')]
class FavoriteController extends AbstractController
{
    #[Route('/', name: 'app_favorite')]
    public function index(UserRepository $database): Response
    {
        $user = $this->getUser();
        $musics = array();

        foreach ($user->getMusics() as $music) {
            $musics[$music->getFruit()][] = $music->toArray();
        }

        return $this->render('pages/favorite/favorite.html.twig', [
            'musicsByFruit' => $musics,
            'user' => $user
        ]);
    }

    #[Route('/add/{fruit}/{idRelease}', name: 'app_favorite_add')]
    public function add(EntityManagerInterface $entityManager, DiscogsAccess $api, string $idRelease, string $fruit): Response
    {
        $musicArray = $api->getRelease($idRelease);

        $music = new Music();

        $music->setTitle($musicArray['title']);
        $music->setFruit($fruit);
        $music->setYear($musicArray['year']);
        $music->setLabel($musicArray['label']);
        $music->setCategories($musicArray['category']);
        $music->setImageUrl($musicArray['image_url']);
        $music->setArtist($musicArray['artist']);
        $music->addUser($this->getUser());

        $entityManager->persist($music);
        $entityManager->flush();

        return $this->redirectToRoute('app_search_fruit',
            ['fruit' => $fruit],
            Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{idRelease}', name: 'app_favorite_delete')]
    public function delete(EntityManagerInterface $entityManager, MusicRepository $musicRepository, string $idRelease): Response {
        $music = $musicRepository->find($idRelease);
        $this->getUser()->removeMusic($music);

        $entityManager->remove($music);
        $entityManager->flush();

        return $this->redirectToRoute('app_favorite', [], Response::HTTP_SEE_OTHER);
    }
}
