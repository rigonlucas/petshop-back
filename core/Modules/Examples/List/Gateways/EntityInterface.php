<?php

namespace Core\Modules\Examples\List\Gateways;

use Core\Generics\Pagination\PaginationInput;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;

interface EntityInterface
{
    public function list(EntityInput $input, PaginationInput $paginationInput): EntityPagiantion;
}