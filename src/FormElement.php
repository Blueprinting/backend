<?php

namespace Blueprinting;

use Blueprinting\Interfaces\FormElementInterface;

abstract class FormElement extends Element implements FormElementInterface
{
    /**
     * @var string[]|null
     */
    private ?array $name;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @param string[]|string $name
     *
     * @return $this
     */
    public function setName($name): self
    {
        if (!is_string($name) && !is_array($name) && $name !== null) {
            throw new \RuntimeException('$name can only be array, string or null');
        }

        $this->name = (is_string($name) ? [$name] : $name);

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
        if (
            ($root = $this->getRoot()) &&
            ($name = $this->getName())
        ) {
            return $root->getRequest()->input(implode('.', $name), $this->getDefaultValue());
        }

        return $this->getDefaultValue();
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
}
