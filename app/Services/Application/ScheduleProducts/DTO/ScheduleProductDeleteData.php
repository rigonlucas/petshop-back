<?php

namespace App\Services\Application\ScheduleProducts\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleProductDeleteData extends DataTransferObject
{
    public ?int $schedule_product_id;
    public ?int $schedule_id;
    public ?int $account_id;
}