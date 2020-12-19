<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Blueprinting\Template;
use JsonException;
use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BlueprintTest extends TestCase
{
    /**
     * Assert blueprint object.
     */
    public function testObject(): void
    {
        $request = new Request('GET', '/');
        $blueprint = Blueprint::make($request);

        self::assertEquals('blueprint', $blueprint->getType());

        $blueprint->addClassName('className1');
        $blueprint->addClassNames(['className2', 'className3']);

        $classNames = $blueprint->getClassNames();

        self::assertNotEmpty($classNames);
        self::assertIsArray($classNames);

        if ($classNames !== null) {
            self::assertContains('className1', $classNames);
            self::assertContains('className2', $classNames);
            self::assertContains('className3', $classNames);
        }
    }

    /**
     * Assert elements array access.
     */
    public function testElements(): void
    {
        $request = new Request('GET', '/');
        $blueprint = Blueprint::make($request);
        $blueprint->children[] = TextField::make();

        $blueprint->children[] = [
            TextField::make(),
            TextField::make(),
        ];

        self::assertCount(3, $blueprint->children);
        self::assertNotNull($blueprint->children->get());
        self::assertTrue(isset($blueprint->children[0]));

        self::assertNotTrue(isset($blueprint->children[5]));

        try {
            $blueprint->children[3] = TextField::make();
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        self::assertInstanceOf(TextField::class, $blueprint->children[3]);
        self::assertCount(4, $blueprint->children);

        try {
            $blueprint->children[] = 0;
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        try {
            $blueprint->children[5] = 0;
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }
    }

    /**
     * Assert elements array access.
     */
    public function testChildren(): void
    {
        $request = new Request('GET', '/');
        $blueprint = Blueprint::make($request);
        $blueprint[] = TextField::make();

        $blueprint[] = [
            TextField::make(),
            TextField::make(),
        ];

        self::assertCount(3, $blueprint);
        self::assertTrue(isset($blueprint[0]));

        self::assertNotTrue(isset($blueprint[5]));

        try {
            $blueprint[3] = TextField::make();
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        self::assertInstanceOf(TextField::class, $blueprint[3]);
        self::assertCount(4, $blueprint);

        try {
            $blueprint[] = 0;
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        try {
            $blueprint[5] = 0;
            self::fail('RuntimeException was not thrown');
        } catch (RuntimeException $e) {
        }

        unset($blueprint[0]);

        self::assertNotTrue(isset($blueprint[0]));
    }

    /**
     * Assert collection construction during setting of a specific index.
     */
    public function testElementsCollection(): void
    {
        $request = new Request('GET', '/');
        $blueprint = Blueprint::make($request);
        $blueprint->children[3] = TextField::make();
        self::assertCount(1, $blueprint->children);

        unset($blueprint->children[3]);

        self::assertCount(0, $blueprint->children);
    }

    /**
     * Assert blueprint serialization.
     */
    public function testSerialization(): void
    {
        $request = new Request('GET', '/');
        $blueprint = Blueprint::make(
            $request,
            new Template('test', [
                'name' => 'value',
            ])
        );

        $blueprint->addClassName('className1');
        $blueprint->children[] = TextField::make();

        $serialization = $blueprint->serialize();

        // Assert base serialization
        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('blueprint', $serialization['type']);

        // Assert template
        self::assertArrayHasKey('template', $serialization);
        self::assertIsArray($serialization['template']);

        // Assert template name
        self::assertArrayHasKey('name', $serialization['template']);
        self::assertEquals('test', $serialization['template']['name']);

        // Assert template params
        self::assertArrayHasKey('params', $serialization['template']);
        self::assertArrayHasKey('name', $serialization['template']['params']);
        self::assertEquals('value', $serialization['template']['params']['name']);

        // Assert classNames
        self::assertArrayHasKey('classNames', $serialization);
        self::assertIsArray($serialization['classNames']);
        self::assertContains('className1', $serialization['classNames']);

        // Assert children
        self::assertArrayHasKey('children', $serialization);
        self::assertNotEmpty($serialization['children']);
        self::assertIsArray($serialization['children']);

        $serialization = json_decode(
            json_encode(
                $blueprint,
                JSON_THROW_ON_ERROR
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        // Assert base serialization
        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('blueprint', $serialization['type']);

        // Assert template
        self::assertArrayHasKey('template', $serialization);
        self::assertIsArray($serialization['template']);

        // Assert template name
        self::assertArrayHasKey('name', $serialization['template']);
        self::assertEquals('test', $serialization['template']['name']);

        // Assert template params
        self::assertArrayHasKey('params', $serialization['template']);
        self::assertArrayHasKey('name', $serialization['template']['params']);
        self::assertEquals('value', $serialization['template']['params']['name']);

        // Assert classNames
        self::assertArrayHasKey('classNames', $serialization);
        self::assertIsArray($serialization['classNames']);
        self::assertContains('className1', $serialization['classNames']);

        // Assert children
        self::assertArrayHasKey('children', $serialization);
        self::assertNotEmpty($serialization['children']);
        self::assertIsArray($serialization['children']);
    }
}
