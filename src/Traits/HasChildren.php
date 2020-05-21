<?php

namespace Blueprinting\Traits;

use Blueprinting\Elements;
use Blueprinting\Interfaces\ElementInterface;
use Illuminate\Support\Collection;

/**
 * Trait HasChildren
 *
 * @package Blueprinting\Traits
 * @property Elements $children
 */
trait HasChildren
{
    /**
     * @var Elements
     */
    private Elements $internalChildren;

    /**
     * @return Elements
     */
    public function getChildrenAttribute(): Elements
    {
        return $this->getChildren();
    }

    /**
     * @return Elements
     */
    public function getChildren(): Elements
    {
        if (!isset($this->internalChildren)) {
            $this->internalChildren = new Elements(($this instanceof ElementInterface ? $this : null));
        }

        return $this->internalChildren;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->getChildren()->offsetExists($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->getChildren()->offsetGet($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->getChildren()->offsetSet($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->getChildren()->offsetUnset($offset);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->getChildren()->count();
    }
}
