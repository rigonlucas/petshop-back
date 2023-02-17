<?php

namespace Core\Modules\Exports\Generics\Collections;

use Core\Modules\Exports\Generics\Entities\Exportacao;

class ExportacaoCollection
{
    private array $collector = [];

    public function add(Exportacao $exportacao): void
    {
        $this->collector[] = $exportacao;
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