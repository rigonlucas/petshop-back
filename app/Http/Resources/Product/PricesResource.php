<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class PricesResource extends JsonResource
{
    function resource($request)
    {
        return [
            'id' => $this->id,
            'cost' => $this->cost,
            'price' => $this->price,
            "activated_at" => $this->activated_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
