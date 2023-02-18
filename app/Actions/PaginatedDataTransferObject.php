<?php

namespace App\Actions;

use Spatie\DataTransferObject\DataTransferObject;

class PaginatedDataTransferObject extends DataTransferObject
{
    public ?string $order_by = 'id';
    public ?string $order_direction = 'asc';
    public int $per_page = 20;
    public ?string $include = null;
    public ?string $include_count = null;
    public ?string $cursor = null;

}