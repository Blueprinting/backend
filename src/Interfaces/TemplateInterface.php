<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface TemplateInterface
{
    /**
     * TemplateInterface constructor.
     *
     * @param string $name
     * @param array|null $params |null
     */
    public function __construct(string $name, array $params = null);

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): self;

    /**
     * @return array|null
     */
    public function getParams(): ?array;

    /**
     * @param array $params
     *
     * @return static
     */
    public function setParams(array $params): self;

    /**
     * @return array
     */
    public function serialize(): array;
}
