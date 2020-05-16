<?php

namespace Blueprinting\Elements;

use Blueprinting\FormElement;
use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\LabelInterface;
use Blueprinting\Interfaces\FormElement\OptionsInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Traits\HasDisabled;
use Blueprinting\Traits\HasLabel;
use Blueprinting\Traits\HasOptions;
use Blueprinting\Traits\HasReadonly;

class Select extends FormElement implements
    DisabledInterface,
    ReadonlyInterface,
    LabelInterface,
    OptionsInterface
{
    use HasDisabled;
    use HasReadonly;
    use HasLabel;
    use HasOptions;

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'select';
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        $value = parent::getValue();

        if (is_numeric($value)) {
            $value = (int)$value;
        }

        return $value;
    }
}
