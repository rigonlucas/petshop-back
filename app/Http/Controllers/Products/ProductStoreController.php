<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Services\Application\Products\DTO\ProductStoreData;
use App\Services\Application\Products\ProductStoreService;

class ProductStoreController extends Controller
{
    public function __invoke(ProductStoreRequest $request, ProductStoreService $service)
    {
        $data = ProductStoreData::fromRequest($request);
        dd($data);
    }
}
