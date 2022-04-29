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
use Agonyz\ContaoMemeGeneratorBundle\Service\TokenGenerator;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\ItemInterface;

class MemeGeneratorContentElementController extends AbstractContentElementController
{
    private RequestHandler $requestHandler;
    private TokenGenerator $tokenGenerator;
    private int $cacheTimeTopMemes;
    private bool $loadBootstrap;

    public function __construct(RequestHandler $requestHandler, TokenGenerator $tokenGenerator, int $cacheTimeTopMemes, bool $loadBootstrap)
    {
        $this->requestHandler = $requestHandler;
        $this->tokenGenerator = $tokenGenerator;
        $this->cacheTimeTopMemes = $cacheTimeTopMemes;
        $this->loadBootstrap = $loadBootstrap;
    }

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $cache = new FilesystemAdapter();
        $result = $cache->get(
            'agonyz_top_memes',
            function (ItemInterface $item) {
                $item->expiresAfter($this->cacheTimeTopMemes);

                return $this->requestHandler->getTopMemes();
            }
        );

        $requestToken = $this->tokenGenerator->generateToken();

        $GLOBALS['TL_BODY'][] = $template::generateScriptTag('bundles/agonyzcontaomemegenerator/javascript/meme_generator.js', null, null);

        if ($this->loadBootstrap) {
            $GLOBALS['TL_BODY'][] = $template::generateStyleTag('bundles/agonyzcontaomemegenerator/css/bootstrap.min.css', null, null);
        }

        return $this->render('@Contao_AgonyzContaoMemeGeneratorBundle/ce_meme_generator.html.twig', [
            'text' => $model->text,
            'memes' => $result['data']['memes'],
            'requestToken' => $requestToken,
        ]);
    }
}
