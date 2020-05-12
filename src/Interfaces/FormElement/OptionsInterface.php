<?php

namespace Blueprinting\Interfaces\FormElement;

interface OptionsInterface
{
    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self;

    /**
     * @return array|null
     */
    public function getOptions(): ?array;
}
