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

    private RequestInterface $request;

    public function __construct(RequestInterface $request, ?TemplateInterface $template = null)
    {
        $this->request = $request;

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

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): self
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
}
