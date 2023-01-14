<?php

namespace Core\Generics\Collections;

class DataCollection
{
    private array $collector = [];

    public function add(int|string $key, mixed $value): self
    {
        $this->collector[$key] = $value;
        return $this;
    }

    public function all(): array
    {
        return $this->collector;
    }
}
