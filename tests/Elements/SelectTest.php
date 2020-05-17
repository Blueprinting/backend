<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Elements\Select;
use Blueprinting\Elements\TextField;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use RuntimeException;

class SelectTest extends TestCase
{
    /**
     * Assert object
     *
     * @return void
     */
    public function testObject(): void
    {
        $element = new Select();
        $element->setName('name');
        $element->setLabel('text');
        $element->setReadonly();
        $element->setDisabled();
        $element->setRequired();
        $element->setDefaultValue('default');

        $element->setOptions(
            [
                1 => 1,
                2 => 2,
            ]
        );

        $element->setMultiple();

        $this->assertNotNull($element->getOptions());
        $this->assertCount(2, $element->getOptions());

        $this->assertEquals('select', $element->getType());
        $this->assertEquals('name', $element->getName()[0]);
        $this->assertEquals('text', $element->getLabel());
        $this->assertTrue($element->isReadonly());
        $this->assertTrue($element->isDisabled());
        $this->assertTrue($element->isRequired());
        $this->assertTrue($element->hasMultiple());
        $this->assertEquals('default', $element->getDefaultValue());

        $element->setDefaultValue(0);
        $this->assertEquals(0, $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(0);
    }

    /**
     * Assert getValue()
     *
     * @return void
     */
    public function testGetValue(): void
    {
        $blueprint = new Blueprint();
        $request = new Request();
        $request->replace(
            [
                'test' => [
                    'field' => 'value',
                ]
            ]
        );

        $blueprint->setRequest($request);

        $element = (new Select())
            ->setName(['test', 'field']);

        $this->assertNull($element->getValue());

        $element->setDefaultValue('default');

        $this->assertEquals('default', $element->getValue());

        $blueprint->children->add($element);

        $this->assertEquals('value', $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(['[invalid name']);
    }

    /**
     * Assert collection construction during adding of a new option
     */
    public function testOptionsCollection(): void
    {
        $element = new Select();
        $element->addOption('name', 'value');
        $this->assertCount(1, $element->getOptions());
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new Select();
        $element->setMultiple();

        $serialization = $element->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('select', $serialization['type']);

        $this->assertArrayHasKey('multiple', $serialization);
        $this->assertTrue($serialization['multiple'], $serialization['multiple']);
    }
}
