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

    public function offsetExists($offset): bool
    {
        return $this->get($offset) !== null;
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

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
