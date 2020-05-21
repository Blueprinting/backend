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
     * @param ElementInterface|null $parent
     */
    public function __construct(ElementInterface $parent = null)
    {
        if ($parent !== null) {
            $this->parent = $parent;
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

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->elements, $this->elements[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->add($value);
            return;
        }

        if (!($value instanceof ElementInterface)) {
            throw new \RuntimeException('$value must be instance of ElementInterface');
        }

        if (!isset($this->elements)) {
            $this->elements = new Collection();
        }

        $this->elements[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if (isset($this->elements, $this->elements[$offset])) {
            unset($this->elements[$offset]);
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return (isset($this->elements) ? $this->elements->count() : 0);
    }

    /**
     * @inheritDoc
     */
    public function serialize(): ?array
    {
        if ($children = $this->get()) {
            return $children->map(
                static function (ElementInterface $element) {
                    return $element->serialize();
                }
            )->toArray();
        }

        return null;
    }
}
