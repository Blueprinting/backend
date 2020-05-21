<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Elements\Section;
use Blueprinting\Elements\TextField;
use Orchestra\Testbench\TestCase;

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

        $this->assertEquals('section', $element->getType());
        $this->assertCount(1, $element);
        $this->assertCount(1, $element->toolbar);
        $this->assertEquals('title', $element->getTitle());
        $this->assertEquals('description', $element->getDescription());

        $element->setTitle('title', null, false);
        $element->setDescription('description', null, false);

        $this->assertEquals('title', $element->getTitle());
        $this->assertEquals('description', $element->getDescription());
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

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('section', $serialization['type']);

        // Assert children
        $this->assertArrayHasKey('children', $serialization);
        $this->assertIsArray($serialization['children']);
        $this->assertNotEmpty($serialization['children']);

        // Assert toolbar
        $this->assertArrayHasKey('toolbar', $serialization);
        $this->assertIsArray($serialization['toolbar']);
        $this->assertNotEmpty($serialization['toolbar']);
    }
}
