<?php

namespace App\Http\Controllers\Products\Product;

use App\Actions\Application\Products\DTO\ProductListData;
use App\Actions\Application\Products\ProductListAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductListController extends Controller
{
    public function __invoke(Request $request, ProductListAction $service): AnonymousResourceCollection
    {
        $data = ProductListData::fromRequest($request);
        $products = $service->list($data, $request->user()->account_id);
        return ProductResource::collection($products);
    }
}
