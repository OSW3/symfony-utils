<?php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

return function (): ArrayNodeDefinition {

    $builder = new TreeBuilder('minify');
    $node = $builder->getRootNode();

    $node
        ->info("Parameters settings of Minify listener.")
        ->addDefaultsIfNotSet()->children()

        ->scalarNode('env')
            ->info("Define the environment for which minification is executed.")
            ->defaultValue('prod')
        ->end()

    ->end();

    return $node;
};