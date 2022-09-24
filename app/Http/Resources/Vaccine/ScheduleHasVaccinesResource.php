<?php

namespace App\Http\Resources\Vaccine;

use App\Http\Resources\Product\VaccineResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleHasVaccinesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'applied' => $this->applied,
            'vaccine' => VaccineResource::make($this->vaccine),
        ];
    }
}
