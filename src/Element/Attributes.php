<?php

declare(strict_types=1);

namespace Blueprinting\Element;

use Blueprinting\Interfaces\Element\AttributesInterface;
use Illuminate\Support\Collection;

class Attributes implements AttributesInterface
{
    private Collection $attributes;

    /**
     * @inheritDoc
     */
    public function get(string $name): ?string
    {
        return (
            (
                isset($this->attributes) &&
                ($attribute = $this->attributes->firstWhere('name', '=', $name))
            ) ?
                $attribute['value'] :
                null
        );
    }

    /**
     * @inheritDoc
     */
    public function getAll(): ?Collection
    {
        return $this->attributes ?? null;
    }

    /**
     * @inheritDoc
     */
    public function set(string $name, string $value): self
    {
        if (!isset($this->attributes)) {
            $this->attributes = new Collection();
        }

        $this->attributes[] = [
            'name' => $name,
            'value' => $value,
        ];

        return $this;
    }

    /**
     * @param mixed $offset
     * @return bool
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->get($offset) !== null;
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        if ($this->get($offset) !== null) {
            $this->attributes = $this->attributes->filter(
                static function ($attribute) use ($offset) {
                    return $attribute['name'] !== $offset;
                }
            )->values();
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return (isset($this->attributes) ? $this->attributes->count() : 0);
    }
}
