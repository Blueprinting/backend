<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementInterface;

abstract class Element implements ElementInterface
{
    /**
     * @var Blueprint
     */
    private Blueprint $root;

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

    /**
     * Set element root.
     *
     * @return Blueprint|null
     */
    public function getRoot(): ?Blueprint
    {
        return ($this instanceof Blueprint ? $this : $this->root ?? null);
    }

    /**
     * Get element root.
     *
     * @param Blueprint $blueprint
     *
     * @return self
     */
    public function setRoot(Blueprint $blueprint): self
    {
        $this->root = $blueprint;
        return $this;
    }
}
