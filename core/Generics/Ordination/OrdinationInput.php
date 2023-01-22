<?php

namespace Core\Modules\Generics\Ordination;

class OrdinationInput
{
    private string $direcao;
    private ?string $coluna;

    public function __construct(?string $coluna = null, string $direcao = 'desc')
    {
        $this->coluna = $coluna;
        $this->direcao = $direcao;
    }

    public function getDirecao(): string
    {
        return $this->direcao;
    }

    public function setDirecao(string $direcao): void
    {
        $this->direcao = $direcao;
    }

    public function getColuna(): ?string
    {
        return $this->coluna;
    }

    public function setColuna(?string $coluna): void
    {
        $this->coluna = $coluna;
    }
}