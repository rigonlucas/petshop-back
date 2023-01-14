<?php

namespace Core\Modules\Examples\List\Enums;

use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;
use ReflectionClass;

enum ErrorCodeEnum: string implements CodeErrorNameEnum
{
    case ENTITY__EDITAR__GENERIC_EXCEPTION = 'Ocorreu um erro genérico ao tentar listar as identiades.';
    case ENTITY__LISTAR__DATABASE_EXCEPTION = 'Ocorreu um erro ao tentar listar identiade.';

    public function getErrorCode(): string
    {
        return str_replace('__', '::', $this->name);
    }
}