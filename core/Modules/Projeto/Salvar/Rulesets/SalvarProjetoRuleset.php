<?php

namespace Core\Projeto\Salvar\Rulesets;

use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\StatusOutput;
use Core\Generics\Pagination\PaginationInput;
use Core\Projeto\Salvar\Enums\ErrorCodeEnum;
use Core\Projeto\Salvar\Outputs\SalvarProjetoOutput;
use Core\Projeto\Salvar\Rules\SalvarProjetoRule;

class SalvarProjetoRuleset
{
    private SalvarProjetoRule $SalvarProjetoRule;

    public function __construct(
        SalvarProjetoRule $SalvarProjetoRule
    ) {
        $this->SalvarProjetoRule = $SalvarProjetoRule;
    }

    public function apply(): SalvarProjetoOutput
    {
        // chamar rules
        return new SalvarProjetoOutput(
            new StatusOutput(
                ResponseEnum::OK,
                ResponseEnum::OK->getCodeName()
            ),
            $AlumParametro
        );
    }
}