<?php

namespace App\Services\Application\Schedules\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleStatusData extends DataTransferObject
{
    public ?int $status;
    public ?int $account_id;
    public ?int $schedule_id;
}