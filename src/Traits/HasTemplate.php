<?php

declare(strict_types=1);

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
     * @return static
     */
    public function setTemplate(TemplateInterface $template): self
    {
        $this->template = $template;
        return $this;
    }
}
