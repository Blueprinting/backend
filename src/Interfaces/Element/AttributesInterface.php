<?php

declare(strict_types=1);

namespace Blueprinting\Interfaces\Element;

use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;

interface AttributesInterface extends ArrayAccess, Countable
{
    public function get(string $name): ?string;
    public function getAll(): ?Collection;
    public function set(string $name, string $value): self;
}
