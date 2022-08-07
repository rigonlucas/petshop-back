<?php

namespace App\Services\Application\Schedules\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleAvailableProfessionalsData extends PaginatedDataTransferObject
{
    public ?string $date_time;
    public ?string $duration;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}