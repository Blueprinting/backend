<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{

    /**
     * Assert attributes.
     */
    public function testAttributeUtilities(): void
    {
        $request = new Request('GET', '/', [
            'Content-Type' => 'application/json',
        ]);

        $blueprint = new Blueprint($request);
        $blueprint->attributes['name'] = 'value';
        $blueprint->attributes['name2'] = 'value2';

        self::assertEquals('value', $blueprint->attributes['name']);

        unset($blueprint->attributes['name']);

        self::assertNotTrue(isset($blueprint->attributes['name']));
        self::assertCount(1, $blueprint->attributes);

        $blueprint->setAttribute('name3', 'value3');
        self::assertEquals('value3', $blueprint->getAttribute('name3'));
    }

    /**
     * Assert serialization.
     */
    public function testSerialization(): void
    {
        $request = new Request('GET', '/', [
            'Content-Type' => 'application/json',
        ]);

        $blueprint = new Blueprint($request);

        $blueprint->attributes->set('name', 'value');
        $blueprint->attributes['name2'] = 'value2';

        $serialization = $blueprint->serialize();

        // Assert base serialization
        self::assertIsArray($serialization);

        // Assert attributes using helper methods
        self::assertArrayHasKey('attributes', $serialization);
        self::assertArrayHasKey('name', $serialization['attributes']);
        self::assertEquals('value', $serialization['attributes']['name']);

        // Assert attributes using ArrayAccess
        self::assertArrayHasKey('attributes', $serialization);
        self::assertArrayHasKey('name2', $serialization['attributes']);
        self::assertEquals('value2', $serialization['attributes']['name2']);
    }
}
