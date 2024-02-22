<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Sodium\add;

class DiscogsAccess {
    // FIELDS
    private const TOKEN = "lvRWdaMImlBsYlbhXrHDDROvsWypZZOGwLwEoCcP";
    private const URL = "https://api.discogs.com/";

    private const NB_RELEASE_PER_PAGE = 15;


    // CONSTRUCTOR
    function __construct(private HttpClientInterface $client) {
    }


    // PUBLIC STATIC METHODS

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function getSearchRelease(string $query): array {

        $response = $this->client->request(
            'GET',
            self::URL . "database/search?query=" . $query . "&type=release&per_page=" . self::NB_RELEASE_PER_PAGE . "&page=1" . "&token=" . self::TOKEN
        );


        return $this->extractData($response->toArray());
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getRelease(string $id): array {

        $response = $this->client->request(
            'GET',
            self::URL . "releases/" . $id . "?token=" . self::TOKEN
        );


        return $response->toArray();
    }

    private function extractData(array $releases): array{
        $releases = $releases['results'];
        $releasesSort = array();

        foreach ($releases as $release) {
            $releaseSort = array();

            $releaseSort['id'] = $release['id'];
            $releaseSort['title'] = $release['title'];

            if(array_key_exists('year',$release)) {
                $releaseSort['year'] = $release['year'];
            } else {
                $releaseSort['year'] = "unknown";
            }

            if(array_key_exists('artists',$release)) {
                $releaseSort['artist'] = $release['artists'][0]['name'];
            }

            $releaseSort['label'] = $release['label'][0];
            $releaseSort['category'] = $release['genre'][0];
            $releaseSort['image_url'] = $release['cover_image'];

            $releasesSort[] = $releaseSort;
        }
        return $releasesSort;
    }
}
