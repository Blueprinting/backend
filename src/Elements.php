<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementInterface;
use Blueprinting\Interfaces\ElementsInterface;
use Illuminate\Support\Collection;

class Elements implements ElementsInterface
{
    /**
     * @var ElementInterface
     */
    private ElementInterface $parent;

    /**
     * @var Collection
     */
    private Collection $elements;

    /**
     * Elements constructor.
     *
     * @param ElementInterface|null $element
     */
    public function __construct(ElementInterface $element = null)
    {
        if ($element !== null) {
            $this->parent = $element;
        }
    }

    /**
     * Add one or more elements to collection.
     *
     * @param ElementInterface|ElementInterface[] $element
     *
     * @return self
     */
    public function add($element): self
    {
        if (!isset($this->elements)) {
            $this->elements = new Collection();
        }

        if (!($element instanceof ElementInterface) && !is_array($element)) {
            throw new \RuntimeException('$element must be either instance of ElementInterface or an array');
        }

        if ($element instanceof ElementInterface) {
            if (isset($this->parent)) {
                $element->setParent($this->parent);
            }

            $this->elements[] = $element;
        } elseif (is_array($element)) {
            foreach ($element as $childElement) {
                $this->add($childElement);
            }
        }

        return $this;
    }

    /**
     * Get collection.
     *
     * @return Collection|null
     */
    public function get(): ?Collection
    {
        return $this->elements ?? null;
    }
}