<?php

namespace Core\Modules\Exports\Generics\Entities;

class Exportacao
{
    private string $filePathExportacao;
    private ?int $organizacaoId;
    private ?int $contaId;
    private string $storageDisk;
    private bool $temErro = false;
    private string $nome;

    /**
     * Esta entidade deve ser utilizada em todas as exportações
     */
    public function __construct(
        string $filePathExportacao,
        string $nome,
        int $organizacaoId = null,
        int $contaId = null
    ) {
        $this->filePathExportacao = $filePathExportacao;
        $this->organizacaoId = $organizacaoId;
        $this->contaId = $contaId;
        $this->nome = $nome;
    }

    public function getOrganizacaoId(): ?int
    {
        return $this->organizacaoId;
    }

    public function getFilePathExportacao(): string
    {
        return $this->filePathExportacao;
    }

    public function getStorageDisk(): string
    {
        return $this->storageDisk;
    }

    public function setStorageDisk(string $storageDisk): self
    {
        $this->storageDisk = $storageDisk;
        return $this;
    }

    public function getContaId(): ?int
    {
        return $this->contaId;
    }

    public function temErro(): bool
    {
        return $this->temErro;
    }

    public function naoTemErro(): bool
    {
        return !$this->temErro;
    }

    public function setTemErro(bool $temErro): self
    {
        $this->temErro = $temErro;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
}