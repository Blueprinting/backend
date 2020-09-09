<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface FormElementInterface extends ElementInterface
{
    /**
     * @param string[]|string $name
     *
     * @return $this
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
     * @param $value
     *
     * @return self
     */
    public function setDefaultValue($value): self;

    /**
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * @param bool|null $required
     *
     * @return $this
     */
    public function setRequired(bool $required = null): self;

    /**
     * @return bool
     */
    public function isRequired(): bool;
}
