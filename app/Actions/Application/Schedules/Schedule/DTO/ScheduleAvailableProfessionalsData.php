<?php

namespace App\Actions\Application\Schedules\Schedule\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleAvailableProfessionalsData extends PaginatedDataTransferObject
{
    public ?string $date_time;
    public ?string $duration;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}