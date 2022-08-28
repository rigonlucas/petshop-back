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
        $array = [];
        foreach (self::cases() as $value){
            $array[] = $value->value;
        }
        return $array[array_rand($array)];
    }
}