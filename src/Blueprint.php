<?php

namespace Blueprinting;

use Blueprinting\Interfaces\Element\WithTemplateInterface;
use Blueprinting\Interfaces\TemplateInterface;
use Blueprinting\Traits\HasChildren;
use Blueprinting\Traits\HasTemplate;
use Illuminate\Http\Request;

class Blueprint extends Element implements WithTemplateInterface
{
    use HasChildren;
    use HasTemplate;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * Blueprint constructor.
     *
     * @param TemplateInterface|null $template
     */
    public function __construct(TemplateInterface $template = null)
    {
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
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request ?? app(Request::class);
    }

    /**
     * @param Request $request
     *
     * @return self
     */
    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }
}
