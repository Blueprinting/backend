<?php

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
        return (isset($this->attributes) ? $this->attributes[$name] ?? null : null);
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
}
