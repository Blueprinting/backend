<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface FormElementInterface extends ElementInterface
{
    /**
     * @param string[]|string|null $name
     */
    public function setName($name): self;

    /**
     * @return string[]|null
     */
    public function getName(): ?array;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param string|string[]|int|int[]|null $value
     */
    public function setDefaultValue($value): self;

    /**
     * @return string|array|null
     */
    public function getDefaultValue();
    public function setRequired(bool $required = true): self;
    public function isRequired(): bool;
}
