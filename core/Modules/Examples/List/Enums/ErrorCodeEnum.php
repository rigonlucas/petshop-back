<?php

namespace Core\Modules\Examples\List\Enums;

use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;

enum ErrorCodeEnum: string implements CodeErrorNameEnum
{
    case ENTITY__LIST__GENERIC_EXCEPTION = 'Generic error';
    case ENTITY__LIST__VALIDATION_EXCEPTION = 'Validation error';

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