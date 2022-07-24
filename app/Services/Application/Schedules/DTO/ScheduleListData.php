<?php

namespace App\Services\Application\Schedules\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleListData extends DataTransferObject
{
    public ?string $period_date = null;
    public ?string $user_id = null;
    public ?int $per_page = null;
    public ?string $include = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}