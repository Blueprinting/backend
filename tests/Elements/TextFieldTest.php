<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;

class TextFieldTest extends TestCase
{
    /**
     * Assert blueprint object
     *
     * @return void
     */
    public function testObject(): void
    {
        $element = new TextField();
        $this->assertEquals('text-field', $element->getType());
    }

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

        $blueprint->addChild($textField);

        $this->assertEquals('value', $textField->getValue());
    }

    /**
     * Assert blueprint serialization.
     *
     * @return void
     */
    public function testSerialization(): void
    {
        $element = new TextField();
        $serialization = $element->serialize();

        $this->assertIsArray($serialization);
        $this->assertArrayHasKey('type', $serialization);
        $this->assertEquals('text-field', $serialization['type']);
    }
}
