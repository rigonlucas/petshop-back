<?php

namespace App\Http\Resources\Product;

use App\Support\AppJsonResource;

class ProductResource extends AppJsonResource
{

    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'cost' => $this->cost_price,
            'price' => $this->price,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }
}
