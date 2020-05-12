<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementInterface;

abstract class Element implements ElementInterface
{
    /**
     * Serialize element for renderer.
     *
     * @return array
     */
    public function serialize(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }

    /**
     * Get element type. Used by renderer.
     *
     * @return string
     */
    abstract public function getType(): string;
}
