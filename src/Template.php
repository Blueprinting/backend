<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\TemplateInterface;

class Template implements TemplateInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $params;

    /**
     * @inheritDoc
     */
    public function __construct(string $name, array $params = null)
    {
        $this->setName($name);

        if ($params !== null) {
            $this->setParams($params);
        }
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): TemplateInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * @inheritDoc
     */
    public function setParams(array $params): TemplateInterface
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getParams(): ?array
    {
        return $this->params ?? null;
    }

    /**
     * @inheritDoc
     */
    public function serialize(): array
    {
        return array_filter(
            [
                'name' => $this->getName(),
                'params' => $this->getParams(),
            ],
            fn($value) => $value !== null
        );
    }
}
