<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface DisabledInterface
{
    public function setDisabled(bool $disabled = true): self;
    public function isDisabled(): bool;
}
