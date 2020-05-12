<?php

namespace Blueprinting\Elements;

use Blueprinting\FormElement;

class TextField extends FormElement
{
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
