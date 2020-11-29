<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\ElementInterface;
use Blueprinting\Interfaces\ElementsInterface;
use Illuminate\Support\Collection;
use RuntimeException;

class Elements implements ElementsInterface
{
    private ElementInterface $parent;
    private Collection $elements;

    public function __construct(?ElementInterface $parent = null)
    {
        if ($parent !== null) {
            $this->parent = $parent;
        }
    }

    /**
     * @inheritDoc
     */
    public function add($element): self
    {
        if (!isset($this->elements)) {
            $this->elements = new Collection();
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
        } else {
            throw new RuntimeException('$element must be either instance of ElementInterface or an array');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(): ?Collection
    {
        return $this->elements ?? null;
    }

    /**
     * @param mixed $offset
     * @return bool
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->elements[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->add($value);
            return;
        }

        if (!($value instanceof ElementInterface)) {
            throw new RuntimeException('$value must be instance of ElementInterface');
        }

        if (!isset($this->elements)) {
            $this->elements = new Collection();
        }

        $this->elements[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        if (isset($this->elements[$offset])) {
            unset($this->elements[$offset]);
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return (isset($this->elements) ? $this->elements->count() : 0);
    }

    public function serialize(): ?array
    {
        if ($children = $this->get()) {
            return $children->map(static fn (ElementInterface $element) => $element->serialize())->toArray();
        }

        return null;
    }
}
