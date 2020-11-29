<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface LabelInterface
{
    public function setLabel(string $text, ?array $replacement = null, bool $translate = true): self;
    public function getLabel(): ?string;
}
