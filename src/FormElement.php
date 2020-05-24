<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Interfaces\FormElementInterface;
use RuntimeException;

abstract class FormElement extends Element implements FormElementInterface
{
    /**
     * @var string[]|null
     */
    private ?array $name;

    /**
     * @var bool
     */
    private bool $required;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * FormElement constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        if ($name !== null) {
            $this->setName($name);
        }
    }

    /**
     * @param string[]|string $name
     *
     * @return $this
     */
    public function setName($name): self
    {
        if (!is_string($name) && !is_array($name) && $name !== null) {
            throw new RuntimeException('$name can only be array, string or null');
        }

        if (is_string($name)) {
            $name = [$name];
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
     * @return string[]|null
     */
    public function getName(): ?array
    {
        return $this->name ?? null;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $defaultValue = $this->getDefaultValue();

        if (
            ($request = $this->getRequest()) &&
            ($name = $this->getName())
        ) {
            return $request->input(implode('.', $name), $defaultValue);
        }

        return $defaultValue;
    }

    /**
     * @param $value
     *
     * @return self
     */
    public function setDefaultValue($value): self
    {
        $this->defaultValue = $value;
        return $this;
    }

    /**
     * @return mixed
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
            fn($value) => $value !== null,
        );

        return array_replace(
            parent::serialize(),
            $serialization
        );
    }

    /**
     * @param bool|null $required
     *
     * @return $this
     */
    public function setRequired(bool $required = null): self
    {
        $this->required = $required ?? true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required ?? false;
    }
}
