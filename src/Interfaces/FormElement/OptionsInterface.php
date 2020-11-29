<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

use Illuminate\Support\Collection;

interface OptionsInterface
{
    public function setOptions(array $options): self;
    public function getOptions(): ?Collection;

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function addOption($key, $value): self;
}
