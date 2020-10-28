<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

use Illuminate\Support\Collection;

interface OptionsInterface
{
    /**
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options): self;

    /**
     * @return Collection|null
     */
    public function getOptions(): ?Collection;

    /**
     * @param string|int $key
     * @param string|int $value
     *
     * @return static
     */
    public function addOption($key, $value): self;
}
