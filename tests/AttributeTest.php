<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
use Orchestra\Testbench\TestCase;

class AttributeTest extends TestCase
{

    /**
     * Assert attributes
     *
     * @return void
     */
    public function testAttributeUtilities(): void
    {
        $blueprint = new Blueprint();
        $blueprint->attributes['name'] = 'value';
        $blueprint->attributes['name2'] = 'value2';

        $this->assertEquals('value', $blueprint->attributes['name']);

        unset($blueprint->attributes['name']);

        $this->assertNotTrue(isset($blueprint->attributes['name']));
        $this->assertCount(1, $blueprint->attributes);
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $blueprint = new Blueprint();

        $blueprint->attributes->set('name', 'value');
        $blueprint->attributes['name2'] = 'value2';

        $serialization = $blueprint->serialize();

        // Assert base serialization
        $this->assertIsArray($serialization);

        // Assert attributes using helper methods
        $this->assertArrayHasKey('attributes', $serialization);
        $this->assertArrayHasKey('name', $serialization['attributes']);
        $this->assertEquals('value', $serialization['attributes']['name']);

        // Assert attributes using ArrayAccess
        $this->assertArrayHasKey('attributes', $serialization);
        $this->assertArrayHasKey('name2', $serialization['attributes']);
        $this->assertEquals('value2', $serialization['attributes']['name2']);
    }
}
