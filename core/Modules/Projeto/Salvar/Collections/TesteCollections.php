<?php

namespace Core\Projeto\Salvar\Collections;

use Core\Projeto\Salvar\Entities\Teste;

class TesteCollection
{
    private array $collector = [];

    public function add(Teste $Teste): void
    {
        $this->collector[] = $Teste;
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