<?php

namespace Blueprinting\Interfaces;

interface ElementInterface
{
    /**
     * Serialize element for renderer.
     *
     * @return array
     */
    public function serialize(): array;

    /**
     * Get element type. Used by renderer.
     *
     * @return string
     */
    public function getType(): string;
}
