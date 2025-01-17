<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleHasProductsResource extends JsonResource
{
    function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'final_price' => $this->final_price,
            'discount' => $this->discount,
            'product' => ProductResource::make($this->product),
        ];
    }
}
