<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use RuntimeException;

class TextFieldTest extends TestCase
{
    /**
     * Assert object
     *
     * @return void
     */
    public function testObject(): void
    {
        $element = new TextField('name', 'label');
        $element->setName('name');
        $element->setLabel('text');
        $element->setReadonly();
        $element->setDisabled();
        $element->setRequired();
        $element->setDefaultValue('default');

        $this->assertEquals('text-field', $element->getType());
        $this->assertEquals('name', $element->getName()[0]);
        $this->assertEquals('text', $element->getLabel());
        $this->assertTrue($element->isReadonly());
        $this->assertTrue($element->isDisabled());
        $this->assertTrue($element->isRequired());
        $this->assertEquals('default', $element->getDefaultValue());

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

        $textField = (new TextField())->setName(['test', 'field']);

        $this->assertNull($textField->getValue());

        $textField->setDefaultValue('default');

        $this->assertEquals('default', $textField->getValue());

        $blueprint->children->add($textField);

        $this->assertEquals('value', $textField->getValue());

        $this->expectException(RuntimeException::class);
        $textField->setName(['[invalid name']);
    }

    /**
     * Assert serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new TextField();
        $element->setReadonly();
        $element->setDisabled();
        $serialization = $element->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('text-field', $serialization['type']);
    }
}
