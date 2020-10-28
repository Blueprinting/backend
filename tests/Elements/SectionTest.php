<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Elements\Section;
use Blueprinting\Elements\TextField;
use PHPUnit\Framework\TestCase;

class SectionTest extends TestCase
{
    /**
     * Assert object
     *
     * @return void
     */
    public function testObject(): void
    {
        $element = new Section('title', 'description', new TextField());
        $element->toolbar[] = new TextField();

        self::assertEquals('section', $element->getType());
        self::assertCount(1, $element);
        self::assertCount(1, $element->toolbar);
        self::assertEquals('title', $element->getTitle());
        self::assertEquals('description', $element->getDescription());

        $element->setTitle('title', null, false);
        $element->setDescription('description', null, false);

        self::assertEquals('title', $element->getTitle());
        self::assertEquals('description', $element->getDescription());
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new Section('title', 'description', new TextField());
        $element->toolbar[] = new TextField();

        $serialization = $element->serialize();

        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('section', $serialization['type']);

        // Assert children
        self::assertArrayHasKey('children', $serialization);
        self::assertIsArray($serialization['children']);
        self::assertNotEmpty($serialization['children']);

        // Assert toolbar
        self::assertArrayHasKey('toolbar', $serialization);
        self::assertIsArray($serialization['toolbar']);
        self::assertNotEmpty($serialization['toolbar']);

        // Assert title
        self::assertArrayHasKey('title', $serialization);
        self::assertIsString($serialization['title']);
        self::assertNotEmpty($serialization['title']);

        // Assert description
        self::assertArrayHasKey('description', $serialization);
        self::assertIsString($serialization['description']);
        self::assertNotEmpty($serialization['description']);
    }
}
