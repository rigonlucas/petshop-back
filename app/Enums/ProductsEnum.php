<?php

namespace App\Enums;

enum ProductsEnum: int
{
    case SERVICE = 1;
    case PRODUCT = 2;

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