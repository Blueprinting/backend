<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface LabelInterface
{
    /**
     * @param string $text
     * @param array|null $replacement
     * @param bool|null $translate
     *
     * @return $this
     */
    public function setLabel(string $text, array $replacement = null, bool $translate = null): self;

    /**
     * @return string|null
     */
    public function getLabel(): ?string;
}
