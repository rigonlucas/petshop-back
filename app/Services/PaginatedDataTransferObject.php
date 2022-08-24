<?php

namespace App\Services;

use Spatie\DataTransferObject\DataTransferObject;

class PaginatedDataTransferObject extends DataTransferObject
{
    public ?string $order_by = null;
    public ?string $order_direction = 'asc';
    public int $per_page = 20;
    public ?string $include = null;
    public ?string $include_count = null;

}