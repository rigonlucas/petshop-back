<?php

namespace Core\Projeto\Salvar\Presenters\Outputs;

use Core\Projeto\Salvar\Outputs\SalvarProjetoOutput;

class SalvarProjetoOutputPresenter
{
    private array $presenter = [];
    private SalvarProjetoOutput $output;

    public function __construct(SalvarProjetoOutput $output /**, parametros**/)
    {
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
            //(new AlgumOutroPresenter($this->pagination))->present()->toArray()
        );
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}