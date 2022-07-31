<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Services\Application\Products\DTO\ProductStoreData;
use App\Services\Application\Products\ProductStoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductStoreController extends Controller
{
    /**
     * @param ProductStoreRequest $request
     * @param ProductStoreService $service
     * @return JsonResponse
     */
    public function __invoke(ProductStoreRequest $request, ProductStoreService $service): JsonResponse
    {
        $data = ProductStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
