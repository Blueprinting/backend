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

    /**
     * @param mixed $offset
     * @return bool
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->getChildren()->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->getChildren()->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        $this->getChildren()->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        $this->getChildren()->offsetUnset($offset);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->getChildren()->count();
    }
}
