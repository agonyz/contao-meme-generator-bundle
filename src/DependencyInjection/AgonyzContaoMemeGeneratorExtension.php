<?php

declare(strict_types=1);

/*
 * This file is part of agonyz/contao-meme-generator-bundle.
 *
 * (c) 2022 agonyz
 *
 * @MIT
 */

namespace Agonyz\ContaoMemeGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AgonyzContaoMemeGeneratorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
        $loader->load('controller.yml');

        // Configuration
        $container->setParameter('agonyz_contao_meme_generator.username', $config['username']);
        $container->setParameter('agonyz_contao_meme_generator.password', $config['password']);
        $container->setParameter('agonyz_contao_meme_generator.cache_top_memes', $config['cache_top_memes']);
        $container->setParameter('agonyz_contao_meme_generator.load_bootstrap', $config['load_bootstrap']);
    }
}
