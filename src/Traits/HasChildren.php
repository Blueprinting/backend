<?php

namespace Blueprinting\Traits;

use Blueprinting\Interfaces\ElementInterface;
use Illuminate\Support\Collection;

trait HasChildren
{
    /**
     * @var Collection
     */
    private Collection $children;

    /**
     * Add a single child.
     *
     * @param ElementInterface $child
     *
     * @return self
     */
    public function addChild(ElementInterface $child): self
    {
        if (!isset($this->children)) {
            $this->children = new Collection();
        }

        $child->setRoot($this->getRoot());

        $this->children[] = $child;

        return $this;
    }

    /**
     * Add one or more children.
     *
     * @param array $children
     *
     * @return self
     */
    public function addChildren(array $children): self
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Get children.
     *
     * @return Collection|null
     */
    public function getChildren(): ?Collection
    {
        return $this->children ?? null;
    }
}
