<?php

namespace Core\Projeto\Salvar\Enums;

use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;

enum ErrorCodeEnum: string implements CodeErrorNameEnum
{
    case ENTITY__ErrorCode__GENERIC_EXCEPTION = 'Generic error';
    case ENTITY__ErrorCode__DATA_BASE_EXCEPTION = 'Database error';

    public function getErrorCode(): string
    {
        return str_replace('__', '::', $this->name);
    }

    public function getCodeNameByValue(string|int $value): string
    {
        return ucwords(
            str_replace(
                '_',
                ' ',
                self::from($value)->name
            )
        );
    }
}