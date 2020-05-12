<?php

namespace Blueprinting\Interfaces;

use Blueprinting\Blueprint;

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

    /**
     * Set element root.
     *
     * @return Blueprint|null
     */
    public function getRoot(): ?Blueprint;

    /**
     * Get element root.
     *
     * @param Blueprint $blueprint
     *
     * @return self
     */
    public function setRoot(Blueprint $blueprint): self;
}
