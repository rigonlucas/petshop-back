<?php

namespace App\Services\Application\Schedules\DTO\Base;

use Spatie\DataTransferObject\DataTransferObject;

class ScheduleBaseData extends DataTransferObject
{
    public int $client_id;
    public int $pet_id;
    public ?int $account_id;
    public int $type;
    public int $status;
    public ?int $user_id = null;
    public string $start_at;
    public int $duration;
    public ?string $description = null;
}