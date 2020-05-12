<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementWithChildrenInterface;
use Blueprinting\Traits\HasChildren;

abstract class ElementWithChildren extends Element implements ElementWithChildrenInterface
{
    use HasChildren;
}
