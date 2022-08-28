<?php

namespace App\Enums;

enum ProductsUnitEnum: int
{
    case UNIT = 1;
    case KG = 2;
    case L = 3;
    case GM = 4;
    case ML = 5;

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
