<?php

declare(strict_types=1);

namespace Blueprinting\Requests;

use Blueprinting\Exceptions\InvalidJsonException;
use Blueprinting\Interfaces\RequestInterface;

/**
 * Class JsonRequest
 * @package Blueprinting\Requests
 * @internal
 */
class JsonRequest implements RequestInterface
{
    private array $data;

    public function __construct(\Psr\Http\Message\RequestInterface $request)
    {
        try {
            if ($body = (string)$request->getBody()) {
                $this->data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            }
        } catch (\JsonException $e) {
            throw new InvalidJsonException('Invalid JSON in request.', $e->getCode(), $e);
        }
    }

    public function getData(): ?array
    {
        return $this->data ?? null;
    }
}
