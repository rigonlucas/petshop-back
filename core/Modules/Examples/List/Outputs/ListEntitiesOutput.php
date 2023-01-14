<?php

namespace Core\Modules\Examples\List\Outputs;

use Core\Generics\Outputs\Interfaces\OutputInterface;
use Core\Generics\Outputs\StatusOutput;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;
use Core\Modules\Examples\List\Presenters\Outputs\ListOutputPresenter;

class ListEntitiesOutput implements OutputInterface
{
    private StatusOutput $status;
    private EntityPagiantion $entityPagination;

    public function __construct(StatusOutput $status, EntityPagiantion $entityPagination)
    {
        $this->status = $status;
        $this->entityPagination = $entityPagination;
    }

    public function getStatus(): StatusOutput
    {
        return $this->status;
    }

    public function getPresenter(): ListOutputPresenter
    {
        return (new ListOutputPresenter($this, $this->getentityPagination()))->present();
    }

    public function getentityPagination(): EntityPagiantion
    {
        return $this->entityPagination;
    }
}