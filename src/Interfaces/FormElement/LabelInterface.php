<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\FormElement;

interface LabelInterface
{
    public function setLabel(string $text): self;
    public function getLabel(): ?string;
}
