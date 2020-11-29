<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface ElementInterface
{
    /**
     * Serialize element for renderer.
     */
    public function serialize(): array;

    /**
     * Get element type. Used by renderer.
     */
    public function getType(): string;

    /**
     * Set parent element.
     */
    public function getParent(): ?ElementInterface;

    /**
     * Get parent element.
     */
    public function setParent(ElementInterface $element): self;
    public function getAttribute(string $name): ?string;
    public function setAttribute(string $name, string $value): self;
    public function addClassName(string $className): self;

    /**
     * @param string[] $classNames
     */
    public function addClassNames(array $classNames): self;

    /**
     * @return string[]|null
     */
    public function getClassNames(): ?array;
}
