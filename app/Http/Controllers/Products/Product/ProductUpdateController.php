<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Services\Application\Products\DTO\ProductUpdateData;
use App\Services\Application\Products\ProductUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductUpdateController extends Controller
{
    /**
     * @param ProductStoreRequest $request
     * @param int $id
     * @param ProductUpdateService $service
     * @return JsonResponse
     */
    public function __invoke(ProductStoreRequest $request, int $id, ProductUpdateService $service): JsonResponse
    {
        $data = ProductUpdateData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->update($data);
        });
        return response()->json(['row_updated' => $result], ResponseAlias::HTTP_OK);
    }
}
