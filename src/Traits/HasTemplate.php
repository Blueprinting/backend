<?php

declare(strict_types=1);

namespace Blueprinting\Traits;

use Blueprinting\Interfaces\TemplateInterface;

trait HasTemplate
{
    private TemplateInterface $template;

    public function getTemplate(): ?TemplateInterface
    {
        return $this->template ?? null;
    }

    public function setTemplate(TemplateInterface $template): self
    {
        $this->template = $template;
        return $this;
    }
}
