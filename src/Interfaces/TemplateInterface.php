<?php

namespace Blueprinting\Interfaces;

interface TemplateInterface
{
    /**
     * TemplateInterface constructor.
     *
     * @param string $name
     * @param array $params
     */
    public function __construct(string $name, array $params);

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return array|null
     */
    public function getParams(): ?array;

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params): self;

    /**
     * @return array
     */
    public function serialize(): array;
}
