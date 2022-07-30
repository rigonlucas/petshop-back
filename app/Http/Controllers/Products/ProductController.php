<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Application\Products\ProductListService;
use App\Services\Application\Products\DTO\ProductListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request, ProductListService $service): AnonymousResourceCollection
    {
        $data = ProductListData::fromRequest($request);

        $products = $service
            ->accountProducts($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return ProductResource::collection($products);
    }
}
