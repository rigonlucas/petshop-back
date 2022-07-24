<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Pet\PetResource;
use App\Http\Resources\User\UserResource;
use App\Support\AppJsonResource;

class SchedulesResource extends AppJsonResource
{
    protected array $availableIncludes = ['pet', 'user', 'client'];

    public function resource($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "client_id" => $this->client_id,
            "account_id" => $this->client_id,
            "pet_id" => $this->client_id,
            "type" => $this->type,
            "status" => $this->status,
            "start_at" => $this->start_at,
            "duration" => $this->duration,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }

    public function includePet(): PetResource
    {
        return PetResource::make($this->pet);
    }

    public function includeUser(): UserResource
    {
        return UserResource::make($this->user);
    }

    public function includeClient(): ClientResource
    {
        return ClientResource::make($this->client);
    }

}
//(new DateTime($this->date))->format(DateTime::ISO8601)