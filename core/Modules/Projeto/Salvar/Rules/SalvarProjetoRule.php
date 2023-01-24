<?php

namespace Core\Projeto\Salvar\Rules;
use Core\Projeto\Salvar\Inputs\SalvarProjetoInput;

class SalvarProjetoRule
{
    public function __construct(SalvarProjetoInput $input)
    {
        $this->input = $input;
    }

    public function apply(): void
    {

    }
}