<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Application\Products\DTO\ProductListData;
use App\Services\Application\Products\ProductListService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductListController extends Controller
{
    /**
     * @param Request $request
     * @param ProductListService $service
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, ProductListService $service): AnonymousResourceCollection
    {
        $abort = $request->user()->hasAnyPermission(['client_access', 'schedule_create', 'schedule_update']);
        abort_if(!$abort, 403);
        $data = ProductListData::fromRequest($request);
        $products = $service->list($data, $request->user()->account_id);
        return ProductResource::collection($products);
    }
}
