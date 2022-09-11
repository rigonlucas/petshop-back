<?php

namespace App\Http\Resources\Schedules;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleHistoryResource extends JsonResource
{
    function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->register,
            'type' => $this->type,
            'schedule_id' => $this->schedule_id,
        ];
    }
}
