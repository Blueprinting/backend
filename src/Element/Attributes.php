<?php

declare(strict_types=1);

namespace Blueprinting\Element;

use Blueprinting\Interfaces\Element\AttributesInterface;
use Illuminate\Support\Collection;

class Attributes implements AttributesInterface
{
    private Collection $attributes;

    /**
     * @param string $name
     *
     * @return string|null
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
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->attributes ?? null;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
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
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->get($offset) !== null;
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if ($value = $this->get($offset)) {
            return $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
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
     * @inheritDoc
     */
    public function count()
    {
        return (isset($this->attributes) ? $this->attributes->count() : 0);
    }
}
