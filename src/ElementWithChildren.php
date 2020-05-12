<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementWithChildrenInterface;

abstract class ElementWithChildren extends Element implements ElementWithChildrenInterface
{
    use HasChildren;
}
