<?php

namespace Blueprinting\Interfaces;

use Illuminate\Support\Collection;

interface ElementWithChildrenInterface extends ElementInterface
{
    /**
     * Add a single child.
     *
     * @param ElementInterface $child
     *
     * @return $this
     */
    public function addChild(ElementInterface $child): self;

    /**
     * Add one or more children.
     *
     * @param array $children
     *
     * @return self
     */
    public function addChildren(array $children): self;

    /**
     * Get children.
     *
     * @return Collection|null
     */
    public function getChildren(): ?Collection;
}
