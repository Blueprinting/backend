<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface DisabledInterface
{
    /**
     * @param bool|null $disabled
     *
     * @return static
     */
    public function setDisabled(bool $disabled = null): self;


    /**
     * @return bool
     */
    public function isDisabled(): bool;
}
