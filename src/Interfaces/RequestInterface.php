<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces;

interface RequestInterface
{
    public function __construct(\Psr\Http\Message\RequestInterface $request);
    public function getData():? array;
}
