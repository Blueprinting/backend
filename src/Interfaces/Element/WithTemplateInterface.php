<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\Element;

use Blueprinting\Interfaces\TemplateInterface;

interface WithTemplateInterface
{
    public function getTemplate(): ?TemplateInterface;
    public function setTemplate(TemplateInterface $template): self;
}
