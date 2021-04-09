<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

trait HasLabel
{
    private string $label;

    public function setLabel(string $text): self
    {
        $this->label = $text;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label ?? null;
    }
}
