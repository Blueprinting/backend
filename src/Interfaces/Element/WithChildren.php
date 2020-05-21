<?php

namespace Blueprinting\Interfaces\Element;

use ArrayAccess;
use Countable;
use Blueprinting\Interfaces\ElementsInterface;

interface WithChildren extends ArrayAccess, Countable
{
    /**
     * @return ElementsInterface
     */
    public function getChildren(): ElementsInterface;
}
