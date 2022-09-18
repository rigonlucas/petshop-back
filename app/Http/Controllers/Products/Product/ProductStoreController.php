<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Services\Application\Products\DTO\ProductStoreData;
use App\Services\Application\Products\ProductStoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductStoreController extends Controller
{
    /**
     * @param ProductStoreRequest $request
     * @param ProductStoreService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(ProductStoreRequest $request, ProductStoreService $service): JsonResponse
    {
        $this->authorize('product_create');
        $data = ProductStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}