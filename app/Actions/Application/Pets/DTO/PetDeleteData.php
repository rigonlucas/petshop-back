<?php

namespace App\Actions\Application\Pets\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PetDeleteData extends DataTransferObject
{
    public ?int $id;
    public ?int $account_id;
}