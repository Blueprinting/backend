<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

trait HasLabel
{
    /**
     * @var string
     */
    private string $label;

    /**
     * @param string $text
     * @param array|null $replacement
     * @param bool|null $translate
     *
     * @return $this
     */
    public function setLabel(string $text, array $replacement = null, bool $translate = null): self
    {
        $this->label = ($translate || $translate === null ? (string)__($text, $replacement ?? []) : $text);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label ?? null;
    }
}
