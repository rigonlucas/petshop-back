<?php

namespace Core\Modules\App\Vaccine\List\Outputs;

use Core\Generics\Outputs\Interfaces\OutputInterface;
use Core\Generics\Outputs\StatusOutput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\App\Vaccine\List\Presenters\Outputs\ListOutputPresenter;

class ListOfVaccinesOutput implements OutputInterface
{
    private StatusOutput $status;
    private ListOfVaccinesPagiantion $entityPagination;

    public function __construct(StatusOutput $status, ListOfVaccinesPagiantion $entityPagination)
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

    public function getentityPagination(): ListOfVaccinesPagiantion
    {
        return $this->entityPagination;
    }
}