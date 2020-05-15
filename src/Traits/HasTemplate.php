<?php

namespace Blueprinting\Traits;

use Blueprinting\Interfaces\TemplateInterface;

trait HasTemplate
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $template;

    /**
     * @return TemplateInterface|null
     */
    public function getTemplate(): ?TemplateInterface
    {
        return $this->template ?? null;
    }

    /**
     * @param TemplateInterface $template
     *
     * @return $this
     */
    public function setTemplate(TemplateInterface $template): self
    {
        $this->template = $template;
        return $this;
    }
}
