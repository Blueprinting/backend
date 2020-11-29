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

    private bool $multiple;

    /**
     * Select constructor.
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

    public function setMultiple(bool $multiple = true): self
    {
        $this->multiple = $multiple ?? true;
        return $this;
    }

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
