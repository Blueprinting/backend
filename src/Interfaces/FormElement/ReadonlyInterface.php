<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface ReadonlyInterface
{
    /**
     * @param bool|null $readonly
     *
     * @return $this
     */
    public function setReadonly(bool $readonly = null): self;


    /**
     * @return bool
     */
    public function isReadonly(): bool;
}
