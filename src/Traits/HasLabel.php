<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

trait HasLabel
{
    private string $label;

    public function setLabel(string $text, ?array $replacement = null, bool $translate = true): self
    {
        // $this->label = ($translate || $translate === null ? (string)__($text, $replacement ?? []) : $text);
        $this->label = $text;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label ?? null;
    }
}
