<?php

namespace Core\Modules\Examples\List\Presenters\Pagination;

use Core\Modules\Examples\List\Pagination\EntityPagiantion;
use Core\Modules\Examples\List\Presenters\Collections\EntityCollectionPresenter;

class PaginationPresenter
{
    private array $presenter = [];
    private EntityPagiantion $pagination;

    public function __construct(EntityPagiantion $pagination)
    {
        $this->pagination = $pagination;
    }

    public function present(): self
    {
        $this->presenter = array_merge(
            [
                'data' => (new EntityCollectionPresenter($this->pagination->getentityCollection()))
                    ->present()
                    ->toArray()
            ],
            [
                'meta' => [
                    'per_page' => $this->pagination->getPerPage(),
                    'current_page' => $this->pagination->getCurrentPage(),
                    'total' => $this->pagination->getTotal(),
                    'last_page' => $this->pagination->getLastPage()
                ]
            ]
        );
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}