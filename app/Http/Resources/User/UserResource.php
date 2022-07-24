<?php

namespace App\Http\Resources\User;

use App\Support\AppJsonResource;

class UserResource extends AppJsonResource
{
    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }
}
