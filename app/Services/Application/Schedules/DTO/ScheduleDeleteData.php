<?php

namespace App\Services\Application\Schedules\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleDeleteData extends DataTransferObject
{
    public ?int $schedule_id = null;
    public ?int $account_id = null;

}