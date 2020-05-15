<?php

namespace Blueprinting\Elements;

use Blueprinting\FormElement;
use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Traits\HasDisabled;
use Blueprinting\Traits\HasReadonly;

class TextField extends FormElement implements
    DisabledInterface,
    ReadonlyInterface
{
    use HasDisabled;
    use HasReadonly;

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'text-field';
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        $value = parent::getValue();

        return ($value !== null ? (string)$value : null);
    }
}
