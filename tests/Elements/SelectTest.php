<?php

namespace Blueprinting\Tests\Elements;

use Blueprinting\Blueprint;
use Blueprinting\Elements\Select;
use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SelectTest extends TestCase
{
    /**
     * Assert object
     */
    public function testObject(): void
    {
        $element = Select::make('name', 'label', [
            1 => 1,
            2 => 2,
        ]);

        $element->setName('name');
        $element->setLabel('label');
        $element->setReadonly();
        $element->setDisabled();
        $element->setRequired();
        $element->setDefaultValue('default');

        $element->setMultiple();
        $optionGroups = $element->getOptionGroups();
        $options = $optionGroups[0]->getOptions();

        self::assertNotNull($options);
        self::assertCount(2, $options);
        self::assertEquals('select', $element->getType());

        $name = $element->getName();
        self::assertNotEmpty($name);
        self::assertIsArray($name);
        self::assertArrayHasKey(0, $name);
        self::assertEquals('name', $name[0]);

        self::assertEquals('label', $element->getLabel());
        self::assertTrue($element->isReadonly());
        self::assertTrue($element->isDisabled());
        self::assertTrue($element->isRequired());
        self::assertTrue($element->hasMultiple());
        self::assertEquals('default', $element->getDefaultValue());

        $element->setDefaultValue(0);
        self::assertEquals(0, $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(0);
    }

    /**
     * Assert getValue()
     */
    public function testGetValue(): void
    {
        $request = new Request('POST', '/', [
            'Content-Type' => 'application/json'
        ], '{"test":{"field":"value"}}');

        $blueprint = Blueprint::make($request);

        $element = Select::make()->setName(['test', 'field']);

        self::assertNull($element->getValue());

        $element->setDefaultValue('default');

        self::assertEquals('default', $element->getValue());

        $blueprint->children->add($element);

        self::assertEquals('value', $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(['[invalid name']);
    }

    /**
     * Assert collection construction during adding of a new option
     */
    public function testOptionsCollection(): void
    {
        $element = Select::make();
        $element->setOptions([1 => 2]);
        self::assertCount(1, $element->getOptionGroups());
    }

    /**
     * Assert serialization.
     */
    public function testSerialization(): void
    {
        $element = Select::make('name', 'label', [1 => 2, 3 => 4]);
        $element->setMultiple();

        $serialization = $element->serialize();

        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('select', $serialization['type']);

        self::assertArrayHasKey('multiple', $serialization);
        self::assertTrue($serialization['multiple'], $serialization['multiple']);

        self::assertArrayHasKey('optionGroups', $serialization);
        self::assertNotEmpty($serialization['optionGroups']);
        self::assertCount(1, $serialization['optionGroups']);
        self::assertArrayHasKey(0, $serialization['optionGroups']);
        self::assertArrayHasKey('text', $serialization['optionGroups'][0]);
        self::assertArrayHasKey('options', $serialization['optionGroups'][0]);
        self::assertCount(2, $serialization['optionGroups'][0]['options']);
    }
}
