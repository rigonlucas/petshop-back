<?php

namespace App\Http\Resources\Admin\User;

use App\Support\AppJsonResource;

class UserResource extends AppJsonResource
{
    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
