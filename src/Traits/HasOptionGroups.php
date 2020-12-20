<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

use Blueprinting\Element\OptionGroup;

trait HasOptionGroups
{
    /**
     * @var OptionGroup[]
     */
    private array $optionGroups;

    /**
     * @param OptionGroup[] $groups
     */
    public function setOptionGroups(array $groups): self
    {
        $this->optionGroups = $groups;
        return $this;
    }

    /**
     * @return OptionGroup[]|null
     */
    public function getOptionGroups(): ?array
    {
        return $this->optionGroups ?? null;
    }
}
