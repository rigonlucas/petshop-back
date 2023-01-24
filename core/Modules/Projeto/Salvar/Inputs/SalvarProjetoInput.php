<?php

namespace Core\Projeto\Salvar\Inputs;


class SalvarProjetoInput
{
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}