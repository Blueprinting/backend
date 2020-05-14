<?php

namespace Blueprinting\Interfaces;

use Illuminate\Support\Collection;

interface ElementsInterface
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
