<?php

namespace Core\Projeto\Salvar\Pagination;

use Core\Generics\Pagination\AbstractPagination;

class SalvarProjetoPagination extends AbstractPagination
{
    /**
     *  ----------------- LEIA-ME ---------------
     *  NÃO ESQUEÇA DE UTILIZAR A CLASSE DEDICADA DE INPUT PARA A PAGINAÇÃO
     *  Core\Generics\Pagination\PaginationInput.php
     **/
    private EntityCollection $entityCollection; //subistitua

    public function __construct(
        entityCollection $entityCollection,
        int $perPage,
        int $currentPage,
        ?int $total = null,
        ?int $lastPage = null
    ) {
        parent::__construct($perPage, $currentPage, $total, $lastPage);

        $this->entityCollection = $entityCollection;
    }

    public function getEntityCollection(): entityCollection
    {
        return $this->entityCollection;
    }

    public function setEntityCollection(entityCollection $entityCollection): void
    {
        $this->entityCollection = $entityCollection;
    }

}