<?php

namespace App\Services\Traits;

trait HasOrderBy
{
    protected string $orderBy= 'id';
    protected string $orderDirection = 'asc';

    private array $availableDirections = [
        'asc',
        'desc'
    ];
    protected array $availableColumns = [
        'id'
    ];

    public function setOrderBy (?string $orderBy, ?string $orderDirection): self
    {
        if (in_array($orderDirection, $this->availableDirections)) {
            $this->orderDirection = $orderDirection;
        }
        if (in_array($orderBy, $this->availableColumns)) {
            $this->orderBy = $orderBy;
        }
        return $this;
    }

    protected abstract function setAvailableColumns();
}