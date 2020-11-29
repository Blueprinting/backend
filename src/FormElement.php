<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\FormElement\DisabledInterface;
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
     * @var mixed
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
     * @throws JsonException
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

    public function getRequestData(): ?array
    {
        if (
            ($request = $this->getRequest()) &&
            ($body = (string)$request->getBody()) &&
            ($body = @json_decode($body, true, 512, JSON_THROW_ON_ERROR))
        ) {
            return $body;
        }

        return null;
    }


    /**
     * @inheritDoc
     */
    public function setDefaultValue($value): self
    {
        $this->defaultValue = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultValue()
    {
        return $this->defaultValue ?? null;
    }

    /**
     * @inheritDoc
     */
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

        return array_replace(
            parent::serialize(),
            $serialization
        );
    }

    public function setRequired(bool $required = true): self
    {
        $this->required = $required ?? true;
        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required ?? false;
    }
}
