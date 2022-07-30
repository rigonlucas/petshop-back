<?php

namespace App\Services\Application\Products;

use App\Services\Application\Products\DTO\ProductStoreData;
use App\Services\BaseService;

class ProductStoreService extends BaseService
{

    public function store(ProductStoreData $data, int $accountId)
    {
        dd($data, $accountId);
    }
}