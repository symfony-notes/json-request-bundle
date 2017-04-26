<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use SymfonyNotes\JsonRequestBundle\EventListener\JsonRequestTransformerListener;
use SymfonyNotes\JsonRequestBundle\EventListener\JsonRequestTransformerListenerInterface;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestDecodeException;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestExceptionInterface;

/**
 * Class JsonRequestExtension
 */
class JsonRequestExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $configs, ContainerBuilder $container)
    {
        $listener = new Definition($configs['request_transformer']);

        $listener
            ->setArguments([
                $configs['decode_depth'],
                $configs['throw_exception_on_error'],
            ])
            ->addTag('kernel.event_listener', [
                'event' => 'kernel.request',
                'method' => 'onKernelRequest',
                'priority' => 100,
            ]);

        $container->setDefinition('notes_json_request.request_transformer', $listener);

        $this->addClassesToCompile([
            JsonRequestTransformerListenerInterface::class,
            JsonRequestTransformerListener::class,
            JsonRequestExceptionInterface::class,
            JsonRequestDecodeException::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'notes_json_request';
    }
}
