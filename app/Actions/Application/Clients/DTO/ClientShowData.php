<?php

namespace App\Actions\Application\Clients\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ClientShowData extends DataTransferObject
{
    public ?string $include;
    public ?int $id;
    public ?int $account_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}