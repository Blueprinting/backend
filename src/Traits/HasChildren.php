<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

use Blueprinting\Elements;
use Blueprinting\Interfaces\ElementInterface;

/**
 * Trait HasChildren
 *
 * @package Blueprinting\Traits
 * @property Elements $children
 */
trait HasChildren
{
    private Elements $internalChildren;

    public function getChildrenAttribute(): Elements
    {
        return $this->getChildren();
    }

    public function getChildren(): Elements
    {
        if (!isset($this->internalChildren)) {
            $this->internalChildren = new Elements(($this instanceof ElementInterface ? $this : null));
        }

        return $this->internalChildren;
    }

    public function offsetExists($offset): bool
    {
        return $this->getChildren()->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getChildren()->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->getChildren()->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->getChildren()->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->getChildren()->count();
    }
}
