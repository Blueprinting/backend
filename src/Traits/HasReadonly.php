<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

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
