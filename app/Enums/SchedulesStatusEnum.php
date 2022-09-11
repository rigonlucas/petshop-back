<?php

namespace App\Enums;

enum SchedulesStatusEnum: int
{
    case SCHEDULED = 1;
    case AWAITING = 2;
    case EXECUTING = 3;
    case ANIMAL_DONE = 4;
    case FINISHED = 5;
    case CANCELED = 6;

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