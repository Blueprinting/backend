<?php

declare(strict_types=1);

namespace Blueprinting\Element;

use Blueprinting\Interfaces\Element\AttributesInterface;

class Attributes implements AttributesInterface
{
    private array $attributes;

    public function get(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function getAll(): ?array
    {
        return $this->attributes ?? null;
    }

    public function set(string $name, string $value): self
    {
        if (!isset($this->attributes)) {
            $this->attributes = [];
        }

        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->get($offset) !== null;
    }

    /**
     * @param mixed $offset
     * @return mixed|string|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        if ($this->get($offset) !== null) {
            unset($this->attributes[$offset]);
        }
    }

    public function count(): int
    {
        return (isset($this->attributes) ? count($this->attributes) : 0);
    }
}
