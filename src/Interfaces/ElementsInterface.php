<?php

declare(strict_types=1);

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
     */
    public function add($element): self;

    /**
     * Get collection.
     */
    public function get(): ?Collection;
    public function serialize(): ?array;
}
