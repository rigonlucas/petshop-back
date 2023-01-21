<?php

namespace Core\Modules\App\Vaccine\List\Inputs;

class VaccineInput
{
    public function __construct(
        readonly ?string $nome = null
    ) {
    }
}