<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Element\Attributes;
use Blueprinting\Interfaces\Element\AttributesInterface;
use Blueprinting\Interfaces\Element\WithChildren;
use Blueprinting\Interfaces\ElementInterface;
use Blueprinting\Interfaces\Element\WithTemplateInterface;

/**
 * Class Element
 * @package Blueprinting
 * @property AttributesInterface $attributes
 */
abstract class Element implements ElementInterface
{
    private ElementInterface $parent;
    private AttributesInterface $internalAttributes;

    /**
     * @var string[]
     */
    private array $classNames;

    /**
     * Get element type. Used by renderer.
     */
    abstract public function getType(): string;

    /**
     * Set parent element.
     */
    public function getParent(): ?ElementInterface
    {
        return $this->parent ?? null;
    }

    /**
     * Get parent element.
     */
    public function setParent(ElementInterface $element): self
    {
        $this->parent = $element;
        return $this;
    }

    public function getAttributesAttribute(): AttributesInterface
    {
        if (!isset($this->internalAttributes)) {
            $this->internalAttributes = new Attributes();
        }

        return $this->internalAttributes;
    }

    public function setAttribute(string $name, string $value): self
    {
        $this->attributes->set($name, $value);
        return $this;
    }

    public function getAttribute(string $name): ?string
    {
        return $this->attributes->get($name);
    }

    public function addClassName(string $className): self
    {
        if (!isset($this->classNames)) {
            $this->classNames = [];
        }

        $this->classNames[] = $className;

        return $this;
    }

    /**
     * @param string[] $classNames
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
     */
    public function serialize(): array
    {
        $serialization = [
            'type' => $this->getType(),
            'attributes' => $this->attributes->getAll(),
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
            static fn($value) => $value !== null
        );
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name) . 'Attribute';

        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }
}
