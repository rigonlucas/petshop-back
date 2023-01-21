<?php

namespace Core\Modules\App\Vaccine\List\Enums;

use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;

enum ErrorCodeEnum: string implements CodeErrorNameEnum
{
    case ENTITY__LIST__GENERIC_EXCEPTION = 'Generic error';
    case ENTITY__LIST__DATA_BASE_EXCEPTION = 'Database error';

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