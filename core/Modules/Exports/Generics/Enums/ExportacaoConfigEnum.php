<?php

namespace Core\Modules\Exports\Generics\Enums;

class ExportacaoConfigEnum
{
    /*
     * 10 * 1024 * 1024 --> São 10 MB [temos que checar qual o tamanho máximo aceito]
     * Validar com o Victor
     */
    public const TAMANHO_DO_MAX_CSV = 10485760;
}