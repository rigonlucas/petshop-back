<?php

namespace Core\Modules\Examples\List\Collections;


use Core\Modules\Examples\List\Entities\Entity;

class EntityCollection
{
    private array $collector = [];

    public function add(Entity $entity): void
    {
        $this->collector[] = $entity;
    }

    public function all(): array
    {
        return $this->collector;
    }

    public function count(): int
    {
        return count($this->collector);
    }
}