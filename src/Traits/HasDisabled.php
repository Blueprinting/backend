<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

trait HasDisabled
{
    private bool $disabled;

    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled ?? false;
    }
}
