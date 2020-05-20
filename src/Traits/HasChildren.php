<?php

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
}
