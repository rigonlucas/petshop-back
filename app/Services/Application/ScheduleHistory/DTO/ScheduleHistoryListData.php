<?php

namespace App\Services\Application\ScheduleHistory\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleHistoryListData extends PaginatedDataTransferObject
{
    public ?string $name = null;
    public ?int $schedule_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}