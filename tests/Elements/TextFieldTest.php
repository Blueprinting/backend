<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Elements\TextField;
use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
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

        self::assertEquals('text-field', $element->getType());
        self::assertEquals('name', $element->getName()[0]); // @phpstan-ignore-line
        self::assertEquals('text', $element->getLabel());
        self::assertTrue($element->isReadonly());
        self::assertTrue($element->isDisabled());
        self::assertTrue($element->isRequired());
        self::assertEquals('default', $element->getDefaultValue());

        $this->expectException(RuntimeException::class);
        $element->setName(0); // @phpstan-ignore-line
    }

    /**
     * Assert getValue()
     *
     * @return void
     */
    public function testGetValue(): void
    {
        $request = new Request('POST', '/', [
            'Content-Type' => 'application/json'
        ], '{"test":{"field":"value"}}');

        $blueprint = new Blueprint($request);
        $blueprint->setRequest($request);

        $textField = (new TextField())->setName(['test', 'field']);

        self::assertNull($textField->getValue());

        $textField->setDefaultValue('default');

        self::assertEquals('default', $textField->getValue());

        $blueprint->children->add($textField);

        self::assertEquals('value', $textField->getValue());

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

        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('text-field', $serialization['type']);
    }
}
