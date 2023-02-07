<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Application\Products\DTO\ProductListData;
use App\Services\Application\Products\ProductListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductListController extends Controller
{
    public function __invoke(Request $request, ProductListService $service): AnonymousResourceCollection
    {
        $data = ProductListData::fromRequest($request);
        $products = $service->list($data, $request->user()->account_id);
        return ProductResource::collection($products);
    }
}
