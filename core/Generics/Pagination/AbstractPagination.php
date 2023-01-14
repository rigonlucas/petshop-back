<?php

namespace Core\Generics\Pagination;

abstract class AbstractPagination
{
    private int $perPage;
    private int $currentPage;
    private ?int $total;
    private ?int $lastPage;

    public function __construct(
        int $perPage,
        int $currentPage,
        ?int $total = null,
        ?int $lastPage = null
    ) {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->total = $total;
        $this->lastPage = $lastPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }
}