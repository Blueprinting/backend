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

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * Blueprint constructor.
     *
     * @param RequestInterface $request
     * @param TemplateInterface|null $template
     */
    public function __construct(RequestInterface $request, TemplateInterface $template = null)
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

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return self
     */
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
