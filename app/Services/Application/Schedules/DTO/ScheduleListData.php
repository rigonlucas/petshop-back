<?php

namespace App\Services\Application\Schedules\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleListData extends PaginatedDataTransferObject
{
    public ?string $period_date = null;
    public ?string $user_id = null;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}