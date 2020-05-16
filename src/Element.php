<?php

namespace Blueprinting;

use Blueprinting\Element\Attributes;
use Blueprinting\Interfaces\Element\AttributesInterface;
use Blueprinting\Interfaces\ElementInterface;
use Blueprinting\Interfaces\Element\WithTemplateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Element
 * @package Blueprinting
 * @property AttributesInterface $attributes
 */
abstract class Element implements ElementInterface
{
    /**
     * @var ElementInterface
     */
    private ElementInterface $parent;

    /**
     * @var AttributesInterface
     */
    private AttributesInterface $internalAttributes;

    /**
     * Serialize element for renderer.
     *
     * @return array
     */
    public function serialize(): array
    {
        $serialization = [
            'type' => $this->getType(),
            'attributes' => (($attributes = $this->attributes->getAll()) ?
                $attributes->pluck('value', 'name')->toArray() :
                null
            ),
        ];

        if (
            $this instanceof WithTemplateInterface &&
            ($template = $this->getTemplate())
        ) {
            $serialization['template'] = $template->serialize();
        }

        return array_filter(
            $serialization,
            fn($value) => $value !== null
        );
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
     * @return AttributesInterface
     */
    public function getAttributesAttribute(): AttributesInterface
    {
        if (!isset($this->internalAttributes)) {
            $this->internalAttributes = new Attributes();
        }

        return $this->internalAttributes;
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
