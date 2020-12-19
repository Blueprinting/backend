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
     * Assert object.
     */
    public function testObject(): void
    {
        $element = TextField::make('name', 'label');
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

        $element->setName(null);
        self::assertNull($element->getName());

        $this->expectException(RuntimeException::class);
        $element->setName(0); // @phpstan-ignore-line
    }

    /**
     * Assert getValue().
     */
    public function testGetValue(): void
    {
        $request = new Request('POST', '/', [
            'Content-Type' => 'application/json'
        ], '{"test":{"field":"value"}}');

        $blueprint = Blueprint::make($request);

        $textField = TextField::make()->setName(['test', 'field']);

        self::assertNull($textField->getValue());

        $textField->setDefaultValue('default');

        self::assertEquals('default', $textField->getValue());

        $blueprint->children->add($textField);

        self::assertEquals('value', $textField->getValue());

        $textField->setName('test2');
        self::assertSame('default', $textField->getValue());

        $this->expectException(RuntimeException::class);
        $textField->setName(['[invalid name']);
    }

    /**
     * Assert serialization.
     */
    public function testSerialization(): void
    {
        $element = TextField::make();
        $element->setReadonly();
        $element->setDisabled();
        $serialization = $element->serialize();

        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('text-field', $serialization['type']);
    }
}
