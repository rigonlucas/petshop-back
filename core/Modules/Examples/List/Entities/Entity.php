<?php

namespace Core\Modules\Examples\List\Entities;

use DateTimeInterface;

class Entity
{
    private int $id;
    private string $nome;
    private string $email;
    private ?DateTimeInterface $dataNascimento;
    private ?string $foto;

    public function __construct(
        int $id,
        string $nome,
        string $email,
        ?DateTimeInterface $dataNascimento,
        ?string $foto = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->dataNascimento = $dataNascimento;
        $this->foto = $foto;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDataNascimento(): ?DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): void
    {
        $this->foto = $foto;
    }
}