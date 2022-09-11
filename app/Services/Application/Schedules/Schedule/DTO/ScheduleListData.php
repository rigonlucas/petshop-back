<?php

namespace App\Services\Application\Schedules\Schedule\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleListData extends PaginatedDataTransferObject
{
    public ?string $start_at_start = null;
    public ?string $start_at_end = null;
    public ?int $user_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}