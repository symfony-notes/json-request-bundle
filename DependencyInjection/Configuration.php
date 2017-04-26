<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use SymfonyNotes\JsonRequestBundle\EventListener\JsonRequestTransformerListener;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder();

        $builder->root('notes_json_request')
            ->children()
                ->booleanNode('throw_exception_on_error')
                    ->defaultFalse()
                ->end()
                ->integerNode('decode_depth')
                    ->defaultValue(512)
                    ->min(1)
                ->end()
                ->scalarNode('request_transformer')
                    ->defaultValue(JsonRequestTransformerListener::class)
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
