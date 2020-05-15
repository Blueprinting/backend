<?php

namespace Blueprinting\Traits;

use Blueprinting\Interfaces\Element\DisabledInterface;

trait HasDisabled
{
    /**
     * @var bool
     */
    private bool $disabled;

    /**
     * @param bool|null $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled = null): self
    {
        $this->disabled = $disabled ?? true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled ?? false;
    }
}
