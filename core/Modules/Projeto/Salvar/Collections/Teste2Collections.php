<?php

namespace Core\Projeto\Salvar\Collections;

use Core\Projeto\Salvar\Entities\Teste2;

class Teste2Collection
{
    private array $collector = [];

    public function add(Teste2 $Teste2): void
    {
        $this->collector[] = $Teste2;
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