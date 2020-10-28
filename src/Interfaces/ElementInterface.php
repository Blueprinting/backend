<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

use Psr\Http\Message\RequestInterface;

interface ElementInterface
{
    /**
     * Serialize element for renderer.
     *
     * @return array
     */
    public function serialize(): array;

    /**
     * Get element type. Used by renderer.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set parent element.
     *
     * @return ElementInterface|null
     */
    public function getParent(): ?ElementInterface;

    /**
     * Get parent element.
     *
     * @param ElementInterface $element
     *
     * @return self
     */
    public function setParent(ElementInterface $element): self;

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface;

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getAttribute(string $name): ?string;

    /**
     * @param string $name
     * @param string $value
     *
     * @return static
     */
    public function setAttribute(string $name, string $value): self;

    /**
     * @param string $className
     *
     * @return static
     */
    public function addClassName(string $className): self;

    /**
     * @param string[] $classNames
     *
     * @return static
     */
    public function addClassNames(array $classNames): self;

    /**
     * @return string[]|null
     */
    public function getClassNames(): ?array;
}
