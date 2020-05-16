<?php

namespace Blueprinting\Traits;

use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * @var Collection
     */
    private Collection $options;

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = new Collection();

        foreach ($options as $key => $value) {
            $this->addOption($key, $value);
        }

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getOptions(): ?Collection
    {
        return $this->options ?? null;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addOption($key, $value): self
    {
        if (!isset($this->options)) {
            $this->options = new Collection();
        }

        $this->options[$key] = $value;

        return $this;
    }
}
