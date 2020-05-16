<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Interfaces\ElementInterface;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use RuntimeException;

abstract class Base extends TestCase
{
    /**
     * @return ElementInterface
     */
    abstract public function getElement(): ElementInterface;

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Assert object
     *
     * @return void
     */
    public function testObject(): void
    {
        $element = $this->getElement();
        $element->setName('name');
        $element->setLabel('text');
        $element->setReadonly();
        $element->setDisabled();
        $element->setDefaultValue('default');

        $this->expectException(RuntimeException::class);
        $element->setName(0);

        $this->assertEquals('text-field', $element->getType());
        $this->assertEquals('name', $element->getName()[0]);
        $this->assertEquals('text', $element->getLabel());
        $this->assertEquals(true, $element->isReadonly());
        $this->assertEquals(true, $element->isDisabled());
        $this->assertEquals('default', $element->getDefaultValue());
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

        $element = (new Select())->setName(['test', 'field']);

        $this->assertNull($element->getValue());

        $element->setDefaultValue('default');

        $this->assertEquals('default', $element->getValue());

        $blueprint->children->add($element);

        $this->assertEquals('value', $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(['[invalid name']);
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new Select();
        $serialization = $element->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('select', $serialization['type']);
    }
}
