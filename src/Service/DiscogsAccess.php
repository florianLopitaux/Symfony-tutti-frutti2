<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DiscogsAccess {
    // FIELDS
    private const TOKEN = "lvRWdaMImlBsYlbhXrHDDROvsWypZZOGwLwEoCcP";
    private const URL = "https://api.discogs.com/";


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
            self::URL . "database/search?query=" . $query . "&type=release" . "&token=" . self::TOKEN
        );

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getRelease(int $id): array {

        $response = $this->client->request(
            'GET',
            self::URL . "releases/" . $id . "?token=" . self::TOKEN
        );

        return $response->toArray();
    }


    // PRIVATE STATIC METHODS
}
