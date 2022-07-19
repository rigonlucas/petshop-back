<?php

namespace App\Enums;

enum UnityEnum: int
{
    case UNITY = 1;
    case KG = 2;
    case L = 3;
    case ML = 4;

    /**
     * @throws \Exception
     */
    public static function random(): int
    {
        return array_rand([
            self::UNITY->value,
            self::KG->value,
            self::L->value,
            self::ML->value,
        ]);
    }
}