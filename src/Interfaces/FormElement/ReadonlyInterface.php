<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface ReadonlyInterface
{
    public function setReadonly(bool $readonly = true): self;
    public function isReadonly(): bool;
}
