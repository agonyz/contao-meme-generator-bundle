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

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class TokenGenerator
{
    private CsrfTokenManagerInterface $csrfTokenManager;
    private string $csrfTokenName;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager, string $csrfTokenName)
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->csrfTokenName = $csrfTokenName;
    }

    public function generateToken(): string
    {
        return $this->csrfTokenManager->getToken($this->csrfTokenName)->getValue();
    }

    public function checkToken(string $tokenValue): bool
    {
        $token = new CsrfToken($this->csrfTokenName, $tokenValue);

        return $this->csrfTokenManager->isTokenValid($token);
    }
}
