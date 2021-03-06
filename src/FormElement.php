<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Element\OptionGroup;
use Blueprinting\Exceptions\InvalidJsonException;
use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\OptionGroupInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Interfaces\FormElementInterface;
use JsonException;
use RuntimeException;

abstract class FormElement extends Element implements FormElementInterface
{
    /**
     * @var string[]|null
     */
    private ?array $name;
    private bool $required;

    /**
     * @var array<int|string>|string|int|null
     */
    private $defaultValue;

    /**
     * FormElement constructor.
     * @param string[]|string|null $name
     */
    public function __construct($name = null)
    {
        if ($name !== null) {
            $this->setName($name);
        }
    }

    /**
     * @inheritDoc
     */
    public function setName($name): self
    {
        if ($name === null) {
            $this->name = null;
            return $this;
        }

        if (is_string($name)) {
            $name = [$name];
        }

        if (!is_array($name)) {
            throw new RuntimeException('$name has to match string|string[]|null');
        }

        // Validate that name is valid
        foreach ($name as $nameItem) {
            if (!preg_match('/^[a-z0-9-_]+$/i', $nameItem)) {
                throw new RuntimeException('$name has to abide by regex matching ^[a-z0-9-_]+$');
            }
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?array
    {
        return $this->name ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        if (
            ($requestData = $this->getRequestData()) &&
            ($name = $this->getName())
        ) {
            // Iterate over names and dig into the request data slice by slice.
            while ($currName = array_shift($name)) {
                if (isset($requestData[$currName])) {
                    $requestData = $requestData[$currName];
                } else {
                    // If index wasn't found fall back to returning the default value
                    return $this->getDefaultValue();
                }
            }

            // All names traversed - return the request data left
            return $requestData;
        }

        return $this->getDefaultValue();
    }

    /**
     * @internal
     */
    public function getRequest(): ?Request
    {
        $parent = $this;
        $i = 0;

        do {
            if ($parent instanceof Blueprint) {
                return $parent->getRequest();
            }

            $parent = $parent->getParent();
            $i++;
        } while ($parent !== null && $i < 100);

        return null;
    }

    public function getRequestData(): ?array
    {
        if ($request = $this->getRequest()) {
            return $request->getData();
        }

        return null;
    }

    public function setDefaultValue($value): self
    {
        $this->defaultValue = $value;
        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue ?? null;
    }

    public function serialize(): array
    {
        $serialization = array_filter(
            [
                'disabled' => ($this instanceof DisabledInterface ? $this->isDisabled() : null),
                'readonly' => ($this instanceof ReadonlyInterface ? $this->isReadonly() : null),
                'required' => $this->isRequired(),
            ],
            static fn($value) => $value !== null,
        );

        if (
            $this instanceof OptionGroupInterface &&
            ($optionGroups = $this->getOptionGroups())
        ) {
            $serialization['optionGroups'] = array_map(
                static function (OptionGroup $optionGroup) {
                    return [
                        'text' => $optionGroup->getText(),
                        'options' => array_map(
                            static function ($value, $key) {
                                return [
                                    'key' => $key,
                                    'value' => $value,
                                ];
                            },
                            $optionGroup->getOptions(),
                            array_keys($optionGroup->getOptions())
                        ),
                    ];
                },
                $optionGroups
            );
        }

        return array_replace(
            parent::serialize(),
            $serialization
        );
    }

    public function setRequired(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required ?? false;
    }
}
