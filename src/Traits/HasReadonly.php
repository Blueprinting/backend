<?php

namespace Blueprinting\Traits;

use Blueprinting\Interfaces\Element\DisabledInterface;

trait HasReadonly
{
    /**
     * @var bool
     */
    private bool $readonly;

    /**
     * @param bool|null $readonly
     *
     * @return $this
     */
    public function setReadonly(bool $readonly = null): self
    {
        $this->readonly = $readonly ?? true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReadonly(): bool
    {
        return $this->readonly ?? false;
    }
}
