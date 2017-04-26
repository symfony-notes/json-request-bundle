<?php

declare (strict_types = 1);

namespace SymfonyNotes\JsonRequestBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use SymfonyNotes\JsonRequestBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use SymfonyNotes\JsonRequestBundle\Exception\JsonRequestExceptionInterface;
use SymfonyNotes\JsonRequestBundle\EventListener\JsonRequestTransformerListener;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Class ConfigurationTest
 */
class ConfigurationTest extends TestCase
{
    public function testConfiguration()
    {
        $configuration = new Configuration();

        self::assertInstanceOf(ConfigurationInterface::class, $configuration);

        $configs = (new Processor())->processConfiguration($configuration, []);

        self::assertArraySubset([], $configs);

        self::assertArrayHasKey('throw_exception_on_error', $configs);
        self::assertInternalType('bool', $configs['throw_exception_on_error']);

        self::assertArrayHasKey('decode_depth', $configs);
        self::assertInternalType('int', $configs['decode_depth']);

        self::assertArrayHasKey('request_transformer', $configs);
        self::assertInternalType('string', $configs['request_transformer']);
        self::assertEquals(JsonRequestTransformerListener::class, $configs['request_transformer']);
    }

    /**
     * @param bool $value
     *
     * @dataProvider throwExceptionOnErrorValidProvider
     */
    public function testThrowExceptionOnErrorValid(bool $value)
    {
        $configs = (new Processor())->processConfiguration(new Configuration(), [[
            'throw_exception_on_error' => $value,
        ]]);

        self::assertEquals($value, $configs['throw_exception_on_error']);
    }

    /**
     * @return array
     */
    public function throwExceptionOnErrorValidProvider()
    {
        return [
            'true' => [true],
            'false' => [false],
        ];
    }

    public function testThrowExceptionOnErrorNotValid()
    {
        self::expectException(InvalidTypeException::class);
        self::expectExceptionMessage('Invalid type for path "notes_json_request.throw_exception_on_error". Expected boolean, but got string.');

        (new Processor())->processConfiguration(new Configuration(), [[
            'throw_exception_on_error' => '111',
        ]]);
    }

    /**
     * @param int $value
     *
     * @dataProvider decodeDepthProvider
     */
    public function testDecodeDepthValid(int $value)
    {
        $configs = (new Processor())->processConfiguration(new Configuration(), [[
            'decode_depth' => $value,
        ]]);

        self::assertEquals($value, $configs['decode_depth']);
    }

    /**
     * @return array
     */
    public function decodeDepthProvider()
    {
        return [
            [1],
            [10],
            [45],
            [234],
        ];
    }

    public function testDecodeDepthNotValid()
    {
        self::expectException(InvalidTypeException::class);
        self::expectExceptionMessage('Invalid type for path "notes_json_request.decode_depth". Expected int, but got string.');

        (new Processor())->processConfiguration(new Configuration(), [[
            'decode_depth' => 'string',
        ]]);
    }

    public function testRequestTransformerValid()
    {
        $configs = (new Processor())->processConfiguration(new Configuration(), [[
            'request_transformer' => JsonRequestExceptionInterface::class,
        ]]);

        self::assertEquals(JsonRequestExceptionInterface::class, $configs['request_transformer']);
    }

    public function testRequestTransformerNotValid()
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('The path "notes_json_request.request_transformer" cannot contain an empty value, but got "".');

        (new Processor())->processConfiguration(new Configuration(), [[
            'request_transformer' => '',
        ]]);
    }
}
