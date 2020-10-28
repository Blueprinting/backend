<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface FormElementInterface extends ElementInterface
{
    /**
     * @param string[]|string|null $name
     *
     * @return static
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
     *
     * @return static
     */
    public function setDefaultValue($value): self;

    /**
     * @return string|array|null
     */
    public function getDefaultValue();

    /**
     * @param bool|null $required
     *
     * @return static
     */
    public function setRequired(bool $required = null): self;

    /**
     * @return bool
     */
    public function isRequired(): bool;
}
