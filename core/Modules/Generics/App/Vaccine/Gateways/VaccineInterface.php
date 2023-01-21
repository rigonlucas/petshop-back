<?php

namespace Core\Modules\Generics\App\Vaccine\Gateways;

use Core\Generics\Pagination\PaginationInput;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;

interface VaccineInterface
{
    public function listOfVaccines(VaccineInput $input, PaginationInput $paginationInput): ListOfVaccinesPagiantion;
}