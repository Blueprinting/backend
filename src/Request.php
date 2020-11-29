<?php

declare(strict_types=1);

namespace Blueprinting;

use Blueprinting\Exceptions\InvalidRequestException;
use Blueprinting\Requests\JsonRequest;
use Psr\Http\Message\RequestInterface;

/**
 * Class Request
 * @package Blueprinting
 * @internal
 */
class Request
{
    private \Blueprinting\Interfaces\RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $contentType = 'application/json';

        if (
            ($contentTypeHeader = $request->getHeader('Content-Type')) &&
            is_array($contentTypeHeader) &&
            isset($contentTypeHeader[0]) &&
            is_string($contentTypeHeader[0])
        ) {
            $contentType = $contentTypeHeader[0];
        }

        switch (strtolower($contentType)) {
            case 'application/json':
                $this->request = new JsonRequest($request);
                break;

            default:
                throw new InvalidRequestException('Unrecognized Content-Type.');
        }
    }

    public function getData(): ?array
    {
        return $this->request->getData();
    }
}
