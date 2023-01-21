<?php

namespace Core\Generics\Pagination;

class PaginationInput
{
    private ?int $perPage;
    private ?int $page;
    private ?int $total;
    private ?int $lastPage;

    public function __construct(int $perPage = 15, int $page = 1, ?int $total = null, ?int $lastPage = null)
    {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->total = $total;
        $this->lastPage = $lastPage;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function getLastPage(): ?int
    {
        return $this->lastPage;
    }
}