<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\App\Products\ProductListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request, ProductListService $service): AnonymousResourceCollection
    {
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('order_by');
        $orderDirection = $request->query('order_direction');

        $products = $service
            ->accountProducts()
            ->setOrderBy($orderBy, $orderDirection)
            ->getQuery()
            ->paginate($perPage);
        return ProductResource::collection($products);
    }
}
