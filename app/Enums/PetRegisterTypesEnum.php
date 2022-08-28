<?php

namespace App\Enums;

enum PetRegisterTypesEnum: int
{
    case HEALTH = 1;
    case BEHAVIOR = 2;
    case OBSERVATION = 3;

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