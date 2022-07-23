<?php

namespace App\Http\Resources\Admin\Client;

use App\Support\AppJsonResource;

class ClientResource extends AppJsonResource
{
    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
