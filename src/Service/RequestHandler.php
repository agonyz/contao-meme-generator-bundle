<?php

declare(strict_types=1);

/*
 * This file is part of agonyz/contao-meme-generator-bundle.
 *
 * (c) 2022 agonyz
 *
 * @MIT
 */

namespace Agonyz\ContaoMemeGeneratorBundle\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RequestHandler
{
    private HttpClientInterface $client;
    private string $imgflipUsername;
    private string $imgflipPassword;

    public function __construct(HttpClientInterface $client, string $imgflipUsername, string $imgflipPassword)
    {
        $this->client = $client;
        $this->imgflipUsername = $imgflipUsername;
        $this->imgflipPassword = $imgflipPassword;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function getTopMemes(): ?array
    {
        try {
            $result = $this->client->request('GET', 'https://api.imgflip.com/get_memes')->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getCode();

            return null;
        }

        return $result;
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function createMeme($memeData): ?string
    {
        try {
            $result = $this->client->request('POST', 'https://api.imgflip.com/caption_image', [
                'body' => [
                    'template_id' => (int) ($memeData['id']),
                    'username' => $this->imgflipUsername,
                    'password' => $this->imgflipPassword,
                    'boxes' => $memeData['boxes'],
                ],
            ])->getContent();
        } catch (TransportExceptionInterface $e) {
            echo $e->getCode();

            return null;
        }

        return $result;
    }
}
