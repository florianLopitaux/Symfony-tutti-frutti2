<?php

namespace App\Controller;

use App\Entity\Music;
use App\Repository\MusicRepository;
use App\Service\DiscogsAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/favorite')]
class FavoriteController extends AbstractController
{
//    #[Route('/', name: 'app_favorite')]
//    public function index(MusicRepository $database): Response
//    {
//        $musics = [];
//        foreach ($database->findAll() as $musicArray){
//            $music = new Music();
//
//            $music->setFruit($musicArray['fruit']);
//            $music->setYear($musicArray['year']);
//            $music->setLabel($musicArray['label']);
//            $music->setArtist($musicArray['artist']);
//            $music->setCategories($musicArray['categories']);
//            $music->setImageUrl($musicArray['image_url']);
//
//            $musics[] = $music;
//        }
//
//
//    }

    #[Route('/add/{fruit}/{idRelease}', name: 'app_favorite_add')]
    public function add(EntityManagerInterface $entityManager, DiscogsAccess $api, string $idRelease, string $fruit): Response
    {
        $musicArray = $api->getRelease($idRelease);

        $music = new Music();

        $music->setFruit($fruit);
        $music->setYear($musicArray['year']);
        $music->setLabel($musicArray['label']);
        $music->setCategories($musicArray['category']);
        $music->setImageUrl($musicArray['image_url']);
        $music->setArtist($musicArray['artist']);
        $music->addUser($this->getUser());

        $entityManager->persist($music);
        $entityManager->flush();

        return $this->redirectToRoute('app_home_search',
            ['fruit' => $fruit],
            Response::HTTP_SEE_OTHER);
    }
}
