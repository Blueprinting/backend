<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

trait HasReadonly
{
    private bool $readonly;

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->readonly ?? false;
    }
}
