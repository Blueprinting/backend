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
        $options = $element->getOptions();

        self::assertNotNull($options);
        self::assertCount(2, $options); // @phpstan-ignore-line
        self::assertEquals('select', $element->getType());

        $name = $element->getName();
        self::assertNotEmpty($name);
        self::assertIsArray($name);
        self::assertArrayHasKey(0, $name); // @phpstan-ignore-line
        self::assertEquals('name', $name[0]); // @phpstan-ignore-line

        self::assertEquals('label', $element->getLabel());
        self::assertTrue($element->isReadonly());
        self::assertTrue($element->isDisabled());
        self::assertTrue($element->isRequired());
        self::assertTrue($element->hasMultiple());
        self::assertEquals('default', $element->getDefaultValue());

        $element->setDefaultValue(0);
        self::assertEquals(0, $element->getValue());

        $this->expectException(RuntimeException::class);
        $element->setName(0); // @phpstan-ignore-line
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
        $element->addOption('name', 'value');
        self::assertCount(1, $element->getOptions()); // @phpstan-ignore-line
    }

    /**
     * Assert serialization.
     */
    public function testSerialization(): void
    {
        $element = Select::make();
        $element->setMultiple();

        $serialization = $element->serialize();

        self::assertIsArray($serialization);
        self::assertArrayHasKey('type', $serialization);
        self::assertEquals('select', $serialization['type']);

        self::assertArrayHasKey('multiple', $serialization);
        self::assertTrue($serialization['multiple'], $serialization['multiple']);
    }
}
