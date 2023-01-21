<?php

namespace Core\Modules\App\Vaccine\List\Presenters\Outputs;

use Core\Modules\App\Vaccine\List\Outputs\ListOfVaccinesOutput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\App\Vaccine\List\Presenters\Pagination\PaginationPresenter;

class ListOutputPresenter
{
    private array $presenter = [];
    private ListOfVaccinesOutput $output;
    private ListOfVaccinesPagiantion $pagination;

    public function __construct(ListOfVaccinesOutput $output, ListOfVaccinesPagiantion $pagination)
    {
        $this->pagination = $pagination;
        $this->output = $output;
    }

    public function present(): self
    {
        $status = [
            'status' => [
                'code' => $this->output->getStatus()->getCode(),
                'message' => $this->output->getStatus()->getMessage()
            ],
        ];
        $this->presenter = array_merge(
            $status,
            (new PaginationPresenter($this->pagination))->present()->toArray()
        );
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}