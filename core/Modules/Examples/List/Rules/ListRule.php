<?php

namespace Core\Modules\Examples\List\Rules;

use Core\Generics\Pagination\PaginationInput;
use Core\Modules\Examples\List\Gateways\EntityInterface;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;

class ListRule
{
    private EntityInterface $entityRepository;
    private EntityInput $input;
    private PaginationInput $paginationInput;

    public function __construct(
        EntityInterface $entityRepository,
        EntityInput $input,
        PaginationInput $paginationInput
    ) {
        $this->entityRepository = $entityRepository;
        $this->input = $input;
        $this->paginationInput = $paginationInput;
    }

    public function apply(): EntityPagiantion
    {
        return $this->entityRepository->list($this->input, $this->paginationInput);
    }
}