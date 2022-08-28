<?php

namespace App\Enums;

enum BreedsEnum: int
{
    case DOG = 1;
    case CAT = 2;

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