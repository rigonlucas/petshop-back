<?php

namespace App\Exceptions\Enum\Schedules;

class InvalidEnumScheduleStatusException extends \Exception
{
    public function render($request)
    {
        return abort(404);
    }
}