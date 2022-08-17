<?php

namespace App\Services\Application\ScheduleHistory\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleHistoryDeleteData extends DataTransferObject
{
    public ?int $schedule_history_id;
    public ?int $schedule_id;
    public ?int $account_id;
}