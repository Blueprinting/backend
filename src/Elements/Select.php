<?php

declare(strict_types=1);

namespace Blueprinting\Elements;

use Blueprinting\Element\OptionGroup;
use Blueprinting\FormElement;
use Blueprinting\Interfaces\FormElement\DisabledInterface;
use Blueprinting\Interfaces\FormElement\LabelInterface;
use Blueprinting\Interfaces\FormElement\OptionGroupInterface;
use Blueprinting\Interfaces\FormElement\ReadonlyInterface;
use Blueprinting\Traits\HasDisabled;
use Blueprinting\Traits\HasLabel;
use Blueprinting\Traits\HasOptionGroups;
use Blueprinting\Traits\HasReadonly;

class Select extends FormElement implements
    DisabledInterface,
    ReadonlyInterface,
    LabelInterface,
    OptionGroupInterface
{
    use HasDisabled;
    use HasReadonly;
    use HasLabel;
    use HasOptionGroups;

    private bool $multiple;

    /**
     * Select constructor.
     *
     * @param string|string[]|null $name
     */
    public function __construct($name = null, ?string $label = null, ?array $options = null)
    {
        parent::__construct($name);

        if ($label !== null) {
            $this->setLabel($label);
        }

        if ($options !== null) {
            $this->setOptions($options);
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
        $this->multiple = $multiple;
        return $this;
    }

    public function hasMultiple(): bool
    {
        return $this->multiple ?? false;
    }

    public function setOptions(array $options): self
    {
        $optionGroups = [];
        $group = null;

        foreach ($options as $key => $value) {
            if ($value instanceof OptionGroup) {
                $optionGroups[] = $value;
            } else {
                if ($group === null) {
                    $group = new OptionGroup([]);
                }

                $group->addOption($key, $value);
            }
        }

        if ($group !== null) {
            $optionGroups[] = $group;
        }

        $this->setOptionGroups($optionGroups);

        return $this;
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

    /**
     * @param string|string[]|null $name
     */
    public static function make($name = null, ?string $label = null, ?array $options = null): Select
    {
        return new Select($name, $label, $options);
    }
}
