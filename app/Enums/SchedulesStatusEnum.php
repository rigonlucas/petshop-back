<?php

namespace App\Enums;

enum SchedulesStatusEnum: int
{
    case OPEN = 1;
    case EXECUTING = 2;
    case ARCHIVED = 3;
    case CANCELED = 4;
    case FINISHED = 5;

    /**
     * @throws \Exception
     */
    public static function random(): int
    {
        return array_rand([
            self::OPEN->value,
            self::EXECUTING->value,
            self::ARCHIVED->value,
            self::CANCELED->value,
            self::FINISHED->value,
        ]);
    }
}