<?php

namespace App\Enums;

enum SchedulesTypesEnum: int
{
    case VETERINARIAN = 1;
    case PET_CUTE = 2;
    case PET_SHOWER = 3;
    case PET_CUTE_SHOWER = 4;

    /**
     * @throws \Exception
     */
    public static function random(): int
    {
        return array_rand([
            self::VETERINARIAN->value,
            self::PET_CUTE->value,
            self::PET_SHOWER->value,
            self::PET_CUTE_SHOWER->value,
        ]);
    }
}