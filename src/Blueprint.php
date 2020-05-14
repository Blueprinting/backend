<?php

namespace Blueprinting;

use Blueprinting\Traits\HasChildren;
use Illuminate\Http\Request;

class Blueprint extends Element
{
    use HasChildren;

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
