<?php

namespace Core\Modules\App\Vaccine\List\Rules;

use Core\Generics\Pagination\PaginationInput;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\Generics\App\Vaccine\Gateways\VaccineInterface;

class FindListOfVaccinesRule
{
    private VaccineInterface $vaccineRepository;
    private VaccineInput $input;
    private PaginationInput $paginationInput;

    public function __construct(
        VaccineInterface $vaccineRepository,
        VaccineInput $input,
        PaginationInput $paginationInput
    ) {
        $this->vaccineRepository = $vaccineRepository;
        $this->input = $input;
        $this->paginationInput = $paginationInput;
    }

    public function apply(): ListOfVaccinesPagiantion
    {
        return $this->vaccineRepository->listOfVaccines($this->input, $this->paginationInput);
    }
}