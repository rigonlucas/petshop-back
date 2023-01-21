<?php

namespace Core\Modules\App\Vaccine\List\Pagination;

use Core\Generics\Pagination\AbstractPagination;
use Core\Modules\App\Vaccine\List\Collections\vaccineCollection;

class ListOfVaccinesPagiantion extends AbstractPagination
{
    private vaccineCollection $entityCollection;

    public function __construct(
        vaccineCollection $entityCollection,
        int $perPage,
        int $currentPage,
        ?int $total = null,
        ?int $lastPage = null
    ) {
        parent::__construct($perPage, $currentPage, $total, $lastPage);

        $this->entityCollection = $entityCollection;
    }

    public function getEntityCollection(): vaccineCollection
    {
        return $this->entityCollection;
    }

    public function setEntityCollection(vaccineCollection $entityCollection): void
    {
        $this->entityCollection = $entityCollection;
    }

}