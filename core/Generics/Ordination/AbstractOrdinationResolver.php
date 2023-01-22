<?php

namespace Core\Modules\Generics\Ordination;

use ColunaPadraoNaoDefinidaException;

abstract class AbstractOrdinationResolver
{
    /**
     *  array relacional [alias => nome_da_coluna_na_tabela]
     *  sobrescreva para os seus valores
     */
    protected array $colunas = [];
    protected string $direcaoPadrao = 'desc';
    private OrdinationInput $ordinationInput;

    public function __construct(OrdinationInput $ordinationInput)
    {
        $this->ordinationInput = $ordinationInput;
    }

    public function resolve(): self
    {
        if (is_null($this->colunaPadrao)) {
            throw new ColunaPadraoNaoDefinidaException();
        }
        $arrayDasColunas = array_keys($this->colunas);
        $indiceDaColuna = array_search($this->ordinationInput->getColuna(), $arrayDasColunas);
        if (!is_bool($indiceDaColuna)) {
            $this->ordinationInput->setColuna($arrayDasColunas[$indiceDaColuna]);
        } else {
            $this->ordinationInput->setColuna($this->colunaPadrao);
        }
        $direcao = strtolower($this->ordinationInput->getDirecao());
        if (in_array($direcao, ['asc', 'desc'])) {
            $this->ordinationInput->setDirecao($direcao);
        } else {
            $this->ordinationInput->setDirecao($this->direcaoPadrao);
        }
        return $this;
    }

    /**
     *  A variável colunaPadrao deve ser retornada
     */
    abstract public function getColunaPadrao(): string;

    public function getOrdinationInput(): OrdinationInput
    {
        return $this->ordinationInput;
    }

    public function getColunas(): array
    {
        return $this->colunas;
    }

    public function getDirecaoPadrao(): string
    {
        return $this->direcaoPadrao;
    }
}