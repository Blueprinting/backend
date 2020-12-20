<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Interfaces\Element\WithChildren;
use Blueprinting\Interfaces\Element\WithTemplateInterface;
use Blueprinting\Interfaces\TemplateInterface;
use Blueprinting\Traits\HasChildren;
use Blueprinting\Traits\HasTemplate;
use Psr\Http\Message\RequestInterface;
use JsonSerializable;

class Blueprint extends Element implements
    WithTemplateInterface,
    WithChildren,
    JsonSerializable
{
    use HasChildren;
    use HasTemplate;

    private Request $request;

    public function __construct(RequestInterface $request, ?TemplateInterface $template = null)
    {
        $this->setRequest(new Request($request));

        if ($template !== null) {
            $this->setTemplate($template);
        }
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'blueprint';
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->serialize();
    }

    public static function make(RequestInterface $request, ?TemplateInterface $template = null): Blueprint
    {
        return new Blueprint($request, $template);
    }
}
