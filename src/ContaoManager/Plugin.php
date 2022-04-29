<?php

declare(strict_types=1);

/*
 * This file is part of agonyz/contao-meme-generator-bundle.
 *
 * (c) 2022 agonyz
 *
 * @MIT
 */

namespace Agonyz\ContaoMemeGeneratorBundle\ContaoManager;

use Agonyz\ContaoMemeGeneratorBundle\AgonyzContaoMemeGeneratorBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(AgonyzContaoMemeGeneratorBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        $file = __DIR__.'/../Resources/config/routes.yml';

        return $resolver->resolve($file)->load($file);
    }
}
