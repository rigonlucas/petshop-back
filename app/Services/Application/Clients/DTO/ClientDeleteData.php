<?php

namespace App\Services\Application\Clients\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ClientDeleteData extends DataTransferObject
{
    public ?int $id = null;
    public ?int $account_id = null;
}