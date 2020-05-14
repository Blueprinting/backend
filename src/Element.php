<?php

namespace Blueprinting;

use Blueprinting\Interfaces\ElementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Element implements ElementInterface
{
    /**
     * @var ElementInterface
     */
    private ElementInterface $parent;

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
     * Set parent element.
     *
     * @return ElementInterface|null
     */
    public function getParent(): ?ElementInterface
    {
        return $this->parent ?? null;
    }

    /**
     * Get parent element.
     *
     * @param ElementInterface $element
     *
     * @return self
     */
    public function setParent(ElementInterface $element): self
    {
        $this->parent = $element;
        return $this;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        $parent = $this;
        $i = 0;

        do {
            if ($parent instanceof Blueprint) {
                return $parent->getRequest();
            }

            $parent = $parent->getParent();
            $i++;
        } while ($parent !== null && $i < 100);

        return null;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst(Str::camel($name)) . 'Attribute';

        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }
}
