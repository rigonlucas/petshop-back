<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Pet\PetResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedulesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "client_id" => $this->client_id,
            "account_id" => $this->account_id,
            "pet_id" => $this->client_id,
            "type" => $this->type,
            "status" => $this->status,
            "start_at" => $this->start_at,
            "finish_at" => $this->finish_at,
            "duration" => $this->duration,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at),
            "pet" => new PetResource($this->whenLoaded('pet')),
            "client" => new ClientResource($this->whenLoaded('client')),
            "user" => new UserResource($this->whenLoaded('user')),
            "hasProducts" => ScheduleHasProductsResource::collection($this->whenLoaded('hasProducts')),
        ];
    }
}