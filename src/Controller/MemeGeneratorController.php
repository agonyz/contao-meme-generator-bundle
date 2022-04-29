<?php

declare(strict_types=1);

/*
 * This file is part of agonyz/contao-meme-generator-bundle.
 *
 * (c) 2022 agonyz
 *
 * @MIT
 */

namespace Agonyz\ContaoMemeGeneratorBundle\Controller;

use Agonyz\ContaoMemeGeneratorBundle\Service\RequestHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemeGeneratorController extends AbstractController
{
    private RequestHandler $requestHandler;
    private LoggerInterface $contaoGeneralLogger;
    private LoggerInterface $contaoErrorLogger;

    public function __construct(RequestHandler $requestHandler, LoggerInterface $contaoGeneralLogger, LoggerInterface $contaoErrorLogger)
    {
        $this->requestHandler = $requestHandler;
        $this->contaoGeneralLogger = $contaoGeneralLogger;
        $this->contaoErrorLogger = $contaoErrorLogger;
    }

    public function generateMeme(Request $request): Response
    {
        $response = json_decode($this->requestHandler->createMeme(json_decode($request->get('data'), true)), true);

        if (false === $response['success']) {
            $this->contaoErrorLogger->error(sprintf('Could not generate meme: %s', $response['error_message']));
        } else {
            $this->contaoGeneralLogger->info('A meme was successfully created by a user.');
        }

        return new JsonResponse([
            'data' => $response,
        ]);
    }
}
