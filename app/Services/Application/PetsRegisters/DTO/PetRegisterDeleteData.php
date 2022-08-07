<?php

namespace App\Services\Application\PetsRegisters\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PetRegisterDeleteData extends DataTransferObject
{
    public ?int $id;
    public ?int $pet_id;
    public ?int $acount_id;
}