<?php

namespace Core\Modules\Examples\List\Inputs;

class ConfigInput
{
    private string $disk;
    private string $diretorio;

    public function __construct(string $disk, string $diretorio)
    {
        $this->disk = $disk;
        $this->diretorio = $diretorio;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getDiretorio(): string
    {
        return $this->diretorio;
    }
}