<?php

namespace Blueprinting\Interfaces\Element;

use Illuminate\Support\Collection;

interface AttributesInterface
{
    /**
     * @param string $name
     *
     * @return string|null
     */
    public function get(string $name): ?string;

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection;

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function set(string $name, string $value): self;
}
