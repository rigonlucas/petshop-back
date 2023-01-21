<?php

namespace Core\Modules\App\Vaccine\List\Presenters\Pagination;

use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\App\Vaccine\List\Presenters\Collections\EntityCollectionPresenter;

class PaginationPresenter
{
    private array $presenter = [];
    private ListOfVaccinesPagiantion $pagination;

    public function __construct(ListOfVaccinesPagiantion $pagination)
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