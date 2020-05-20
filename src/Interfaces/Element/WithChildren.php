<?php

namespace Blueprinting\Interfaces\Element;

use Blueprinting\Interfaces\ElementsInterface;

interface WithChildren
{
    /**
     * @return ElementsInterface
     */
    public function getChildren(): ElementsInterface;
}
