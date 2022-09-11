<?php

namespace App\Services\Application\Schedules\Schedule\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleDeleteData extends DataTransferObject
{
    public ?int $schedule_id = null;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}