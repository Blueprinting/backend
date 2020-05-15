<?php

namespace Blueprinting\Interfaces;

interface ElementWithTemplateInterface
{
    /**
     * @return TemplateInterface|null
     */
    public function getTemplate(): ?TemplateInterface;

    /**
     * @param TemplateInterface $template
     *
     * @return $this
     */
    public function setTemplate(TemplateInterface $template): self;
}
