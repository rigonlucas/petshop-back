<?php

namespace App\Actions\Application\Pets\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetShowData extends DataTransferObject
{
    public ?int $id;
    public ?int $account_id = null;
    public ?string $include = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}