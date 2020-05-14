<?php

namespace Blueprinting\Interfaces;

use Illuminate\Http\Request;

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
     * Set parent element.
     *
     * @return ElementInterface|null
     */
    public function getParent(): ?ElementInterface;

    /**
     * Get parent element.
     *
     * @param ElementInterface $element
     *
     * @return self
     */
    public function setParent(ElementInterface $element): self;

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request;
}
