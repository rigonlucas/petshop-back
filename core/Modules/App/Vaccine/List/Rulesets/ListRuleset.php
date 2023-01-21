<?php

namespace Core\Modules\App\Vaccine\List\Rulesets;

use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\StatusOutput;
use Core\Generics\Pagination\PaginationInput;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\Outputs\ListOfVaccinesOutput;
use Core\Modules\App\Vaccine\List\Rules\FindListOfVaccinesRule;
use Core\Modules\Generics\App\Vaccine\Gateways\VaccineInterface;

class ListRuleset
{
    private VaccineInterface $vaccineRepository;
    private VaccineInput $input;
    private PaginationInput $inputpagination;

    public function __construct(
        VaccineInterface $vaccineRepository,
        VaccineInput $input,
        PaginationInput $inputpagination,
    ) {
        $this->vaccineRepository = $vaccineRepository;
        $this->input = $input;
        $this->inputpagination = $inputpagination;
    }

    public function apply(): ListOfVaccinesOutput
    {
        $entitiesPaginated = (new FindListOfVaccinesRule(
            $this->vaccineRepository,
            $this->input,
            $this->inputpagination
        ))->apply();
        return new ListOfVaccinesOutput(
            new StatusOutput(
                ResponseEnum::OK,
                ResponseEnum::OK->getCodeName()
            ),
            $entitiesPaginated
        );
    }
}