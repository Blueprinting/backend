<?php

namespace Blueprinting\Tests;

use Blueprinting\Blueprint;
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
     * Assert blueprint serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $blueprint = new Blueprint();
        $serialization = $blueprint->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('blueprint', $serialization['type']);
    }
}
