<?php

declare(strict_types=1);

namespace Blueprinting\Elements;

use Blueprinting\FormElement;
use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\LabelInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Traits\HasDisabled;
use Blueprinting\Traits\HasLabel;
use Blueprinting\Traits\HasReadonly;

class TextField extends FormElement implements
    DisabledInterface,
    ReadonlyInterface,
    LabelInterface
{
    use HasDisabled;
    use HasReadonly;
    use HasLabel;

    /**
     * TextField constructor.
     *
     * @param string|string[]|null $name
     */
    public function __construct($name = null, ?string $label = null)
    {
        parent::__construct($name);

        if ($label !== null) {
            $this->setLabel($label);
        }
    }

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

    /**
     * @param string|string[]|null $name
     */
    public static function make($name = null, ?string $label = null): TextField
    {
        return new TextField($name, $label);
    }
}
