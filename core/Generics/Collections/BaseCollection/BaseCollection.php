<?php

namespace Core\Generics\Collections\BaseCollection;

class BaseCollection
{
    protected array $collector = [];

    public function all(): array
    {
        return $this->collector;
    }

    public function count(): int
    {
        return count($this->collector);
    }
}