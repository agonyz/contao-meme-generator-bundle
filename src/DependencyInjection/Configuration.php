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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('agonyz_contao_meme_generator');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('username')
                    ->info('Username for the imgflip account.')
                    ->cannotBeEmpty()
                    ->defaultValue('')
                ->end()
                ->scalarNode('password')
                    ->info('Password for the imgflip account.')
                    ->cannotBeEmpty()
                    ->defaultValue('')
                ->end()
                ->integerNode('cache_top_memes')
                    ->info('Time that the top meme information should be stored till next request (in seconds).')
                    ->defaultValue(86400)
                ->end()
                ->booleanNode('load_bootstrap')
                    ->info('Do you want to load bootstrap for styling?')
                    ->defaultValue(true)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
