<?php

namespace Core\Projeto\Salvar\Outputs;

use Core\Generics\Outputs\Interfaces\OutputInterface;
use Core\Generics\Outputs\StatusOutput;
use Core\Projeto\Salvar\Presenters\Outputs\SalvarProjetoOutputPresenter;

class SalvarProjetoOutput implements OutputInterface
{
    private StatusOutput $status;

    public function __construct(StatusOutput $status /**, parametros**/)
    {
        $this->status = $status;
    }

    public function getStatus(): StatusOutput
    {
        return $this->status;
    }

    public function getPresenter(): SalvarProjetoOutputPresenter
    {
        return (new SalvarProjetoOutputPresenter($this, /**parametro**/))->present();
    }

    public function getAlumParametro(): AlumParametro
    {
        return $this->AlumParametro;
    }
}