<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Blueprinting\Template;
use Orchestra\Testbench\TestCase;

class BlueprintTest extends TestCase
{
    /**
     * Assert blueprint object
     *
     * @return void
     */
    public function testObject(): void
    {
        $blueprint = new Blueprint();
        $this->assertEquals('blueprint', $blueprint->getType());
    }

    /**
     * Assert elements array access
     *
     * @return void
     */
    public function testElementsArrayAccess(): void
    {
        $blueprint = new Blueprint();
        $blueprint->children[] = new TextField();

        $this->assertCount(1, $blueprint->children);
    }

    /**
     * Assert blueprint serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $blueprint = new Blueprint(
            new Template('test', [
                'name' => 'value',
            ])
        );

        $blueprint->attributes->set('name', 'value');
        $blueprint->attributes['name2'] = 'value2';

        $serialization = $blueprint->serialize();

        // Assert base serialization
        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('blueprint', $serialization['type']);

        // Assert template
        $this->assertArrayHasKey('template', $serialization);
        $this->assertIsArray($serialization['template']);

        // Assert template name
        $this->assertArrayHasKey('name', $serialization['template']);
        $this->assertEquals('test', $serialization['template']['name']);

        // Assert template params
        $this->assertArrayHasKey('params', $serialization['template']);
        $this->assertArrayHasKey('name', $serialization['template']['params']);
        $this->assertEquals('value', $serialization['template']['params']['name']);

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
