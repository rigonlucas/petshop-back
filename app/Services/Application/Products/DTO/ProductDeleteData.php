<?php

namespace App\Services\Application\Products\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ProductDeleteData extends DataTransferObject
{
    public ?int $id;
    public ?int $account_id;
}