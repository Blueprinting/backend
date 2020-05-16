<?php

namespace Blueprinting\Interfaces;

use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;

interface ElementsInterface extends ArrayAccess, Countable
{
    /**
     * Add one or more elements to collection.
     *
     * @param ElementInterface|ElementInterface[] $element
     *
     * @return self
     */
    public function add($element): self;

    /**
     * Get collection.
     *
     * @return Collection|null
     */
    public function get(): ?Collection;
}
