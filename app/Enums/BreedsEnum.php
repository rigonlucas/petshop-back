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
        return array_rand([
            self::DOG->value,
            self::CAT->value
        ]);
    }
}