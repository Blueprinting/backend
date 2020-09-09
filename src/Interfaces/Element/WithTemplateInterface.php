<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\Element;

use Blueprinting\Interfaces\TemplateInterface;

interface WithTemplateInterface
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
