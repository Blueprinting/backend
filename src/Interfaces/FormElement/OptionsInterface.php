<?php

namespace Blueprinting\Interfaces\FormElement;

use Illuminate\Support\Collection;

interface OptionsInterface
{
    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self;

    /**
     * @return Collection|null
     */
    public function getOptions(): ?Collection;

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addOption($key, $value): self;
}
