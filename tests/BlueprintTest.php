<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Blueprinting\Template;
use Orchestra\Testbench\TestCase;
use RuntimeException;

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

        $blueprint->addClassName('className1');
        $blueprint->addClassNames(['className2', 'className3']);

        $classNames = $blueprint->getClassNames();

        $this->assertNotEmpty($classNames);
        $this->assertIsArray($classNames);
        $this->assertContains('className1', $classNames);
        $this->assertContains('className2', $classNames);
        $this->assertContains('className3', $classNames);
    }

    /**
     * Assert elements array access
     *
     * @return void
     */
    public function testElements(): void
    {
        $blueprint = new Blueprint();
        $blueprint->children[] = new TextField();

        $blueprint->children[] = [
            new TextField(),
            new TextField(),
        ];

        $this->assertCount(3, $blueprint->children);
        $this->assertNotNull($blueprint->children->get());
        $this->assertTrue(isset($blueprint->children[0]));

        $this->assertNotTrue(isset($blueprint->children[5]));

        try {
            $blueprint->children[3] = new TextField();
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        $this->assertInstanceOf(TextField::class, $blueprint->children[3]);
        $this->assertCount(4, $blueprint->children);

        try {
            $blueprint->children[] = 0;
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        try {
            $blueprint->children[5] = 0;
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }
    }

    /**
     * Assert elements array access
     *
     * @return void
     */
    public function testChildren(): void
    {
        $blueprint = new Blueprint();
        $blueprint[] = new TextField();

        $blueprint[] = [
            new TextField(),
            new TextField(),
        ];

        $this->assertCount(3, $blueprint);
        $this->assertTrue(isset($blueprint[0]));

        $this->assertNotTrue(isset($blueprint[5]));

        try {
            $blueprint[3] = new TextField();
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        $this->assertInstanceOf(TextField::class, $blueprint[3]);
        $this->assertCount(4, $blueprint);

        try {
            $blueprint[] = 0;
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        try {
            $blueprint[5] = 0;
            $this->fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }
    }

    /**
     * Assert collection construction during setting of a specific index
     */
    public function testElementsCollection(): void
    {
        $blueprint = new Blueprint();
        $blueprint->children[3] = new TextField();
        $this->assertCount(1, $blueprint->children);

        unset($blueprint->children[3]);

        $this->assertCount(0, $blueprint->children);
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

        $blueprint->addClassName('className1');
        $blueprint->children[] = new TextField();

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

        // Assert classNames
        $this->assertArrayHasKey('classNames', $serialization);
        $this->assertIsArray($serialization['classNames']);
        $this->assertContains('className1', $serialization['classNames']);

        // Assert children
        $this->assertArrayHasKey('children', $serialization);
        $this->assertNotEmpty($serialization['children']);
        $this->assertIsArray($serialization['children']);
    }
}
