<?php

declare(strict_types=1);

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
     * @var bool
     */
    private bool $multiple;

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

    /**
     * @param bool $multiple
     *
     * @return $this
     */
    public function setMultiple(bool $multiple = null): self
    {
        $this->multiple = $multiple ?? true;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMultiple(): bool
    {
        return $this->multiple ?? false;
    }

    /**
     * @inheritDoc
     */
    public function serialize(): array
    {
        return array_replace(
            parent::serialize(),
            [
                'multiple' => $this->hasMultiple(),
            ]
        );
    }
}
