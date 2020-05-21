<?php

namespace Blueprinting;

use Blueprinting\Element\Attributes;
use Blueprinting\Interfaces\Element\AttributesInterface;
use Blueprinting\Interfaces\Element\WithChildren;
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
     * @var string[]
     */
    private array $classNames;

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
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function setAttribute(string $name, string $value): self
    {
        $this->attributes->set($name, $value);
        return $this;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getAttribute(string $name): ?string
    {
        return $this->attributes->get($name);
    }

    /**
     * @param string $className
     *
     * @return $this
     */
    public function addClassName(string $className): self
    {
        if (!isset($this->classNames)) {
            $this->classNames = [];
        }

        $this->classNames[] = $className;

        return $this;
    }

    /**
     * @param array $classNames
     *
     * @return $this
     */
    public function addClassNames(array $classNames): self
    {
        foreach ($classNames as $className) {
            $this->addClassName($className);
        }

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getClassNames(): ?array
    {
        return $this->classNames ?? null;
    }

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
            'classNames' => $this->getClassNames(),
        ];

        if (
            $this instanceof WithTemplateInterface &&
            ($template = $this->getTemplate())
        ) {
            $serialization['template'] = $template->serialize();
        }

        if ($this instanceof WithChildren) {
            $serialization['children'] = $this->getChildren()->serialize();
        }

        return array_filter(
            $serialization,
            fn($value) => $value !== null
        );
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
