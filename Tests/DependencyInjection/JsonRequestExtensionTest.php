<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use SymfonyNotes\JsonRequestBundle\DependencyInjection\JsonRequestExtension;

/**
 * Class JsonRequestExtensionTest
 */
class JsonRequestExtensionTest extends TestCase
{
    public function testAlias()
    {
        $extension = new JsonRequestExtension();
        self::assertStringEndsWith('notes_json_request', $extension->getAlias());
    }

    public function testHasListener()
    {
        $container = new ContainerBuilder();
        $extension = new JsonRequestExtension();

        $listenerService = 'notes_json_request.request_transformer';
        self::assertInstanceOf(Extension::class, $extension);

        $extension->load([], $container);
        self::assertTrue($container->has($listenerService));
    }
}
