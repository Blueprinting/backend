<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\Element;

use ArrayAccess;
use Countable;
use Blueprinting\Interfaces\ElementsInterface;

interface WithChildren extends ArrayAccess, Countable
{
    public function getChildren(): ElementsInterface;
}
