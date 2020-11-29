<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface TemplateInterface
{
    public function __construct(string $name, ?array $params = null);
    public function getName(): ?string;
    public function setName(string $name): self;
    public function getParams(): ?array;
    public function setParams(array $params): self;
    public function serialize(): array;
}
