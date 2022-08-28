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
        $array = [];
        foreach (self::cases() as $value){
            $array[] = $value->value;
        }
        return $array[array_rand($array)];
    }
}