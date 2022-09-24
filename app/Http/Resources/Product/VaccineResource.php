<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class VaccineResource extends JsonResource
{
    function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'number_first_shoot' => $this->number_first_shoot,
            'number_first_shoot_days' => $this->number_first_shoot_days,
            'days_to_booster_dose' => $this->days_to_booster_dose,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
