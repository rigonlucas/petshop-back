<?php

namespace App\Services;

use Spatie\DataTransferObject\DataTransferObject;

class PaginatedDataTransferObject extends DataTransferObject
{
    public ?string $order_by = null;
    public ?string $order_direction = null;
    public ?int $per_page = null;
    public ?string $include = null;

}