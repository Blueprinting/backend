<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\Element;

use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;

interface AttributesInterface extends ArrayAccess, Countable
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
     * @return static
     */
    public function set(string $name, string $value): self;
}
