<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

use ArrayAccess;
use Countable;

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
    public function get(): ?array;
    public function serialize(): ?array;
}
