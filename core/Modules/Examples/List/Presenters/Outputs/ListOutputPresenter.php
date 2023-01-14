<?php

namespace Core\Modules\Examples\List\Presenters\Outputs;

use Core\Modules\Examples\List\Outputs\ListEntitiesOutput;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;
use Core\Modules\Examples\List\Presenters\Pagination\PaginationPresenter;

class ListOutputPresenter
{
    private array $presenter = [];
    private ListEntitiesOutput $output;
    private EntityPagiantion $pagination;

    public function __construct(ListEntitiesOutput $output, EntityPagiantion $pagination)
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