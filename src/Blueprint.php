<?php

namespace Blueprinting;

use Illuminate\Http\Request;

class Blueprint extends ElementWithChildren
{
    /**
     * @var Request
     */
    private Request $request;

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
