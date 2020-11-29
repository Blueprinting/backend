<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\TemplateInterface;

class Template implements TemplateInterface
{
    private string $name;
    private array $params;

    public function __construct(string $name, ?array $params = null)
    {
        $this->setName($name);

        if ($params !== null) {
            $this->setParams($params);
        }
    }

    public function setName(string $name): TemplateInterface
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setParams(array $params): TemplateInterface
    {
        $this->params = $params;
        return $this;
    }

    public function getParams(): ?array
    {
        return $this->params ?? null;
    }

    public function serialize(): array
    {
        return array_filter(
            [
                'name' => $this->getName(),
                'params' => $this->getParams(),
            ],
            static fn($value) => $value !== null
        );
    }
}
