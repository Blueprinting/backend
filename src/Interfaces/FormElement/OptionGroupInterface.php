<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

use Blueprinting\Element\OptionGroup;

interface OptionGroupInterface
{
    /**
     * @param OptionGroup[] $groups
     */
    public function setOptionGroups(array $groups): self;

    /**
     * @return OptionGroup[]|null
     */
    public function getOptionGroups(): ?array;
}
