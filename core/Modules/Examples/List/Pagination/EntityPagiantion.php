<?php

namespace Core\Modules\Examples\List\Pagination;

use Core\Generics\Pagination\AbstractPagination;
use Core\Modules\Examples\List\Collections\EntityCollection;

class EntityPagiantion extends AbstractPagination
{
    private EntityCollection $entityCollection;

    public function __construct(
        EntityCollection $entityCollection,
        int $perPage,
        int $currentPage,
        ?int $total = null,
        ?int $lastPage = null
    ) {
        parent::__construct($perPage, $currentPage, $total, $lastPage);

        $this->entityCollection = $entityCollection;
    }

    public function getentityCollection(): EntityCollection
    {
        return $this->entityCollection;
    }
    
    public function setentityCollection(EntityCollection $entityCollection): void
    {
        $this->entityCollection = $entityCollection;
    }

}