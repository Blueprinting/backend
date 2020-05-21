<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Elements\Section;
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
        $element = new Section();
        $this->assertEquals('section', $element->getType());
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new Section();
        $serialization = $element->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('section', $serialization['type']);
    }
}
