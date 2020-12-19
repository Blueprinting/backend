<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Elements\Section;
use Blueprinting\Elements\TextField;
use PHPUnit\Framework\TestCase;

class SectionTest extends TestCase
{
    /**
     * Assert object.
     */
    public function testObject(): void
    {
        $element = Section::make('title', 'description', [TextField::make()]);
        $element->toolbar[] = TextField::make();

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
     */
    public function testSerialization(): void
    {
        $element = Section::make('title', 'description', [TextField::make()]);
        $element->toolbar[] = TextField::make();

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
