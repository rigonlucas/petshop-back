<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Services\Application\Products\DTO\ProductUpdateData;
use App\Services\Application\Products\ProductUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductUpdateController extends Controller
{
    public function __invoke(ProductStoreRequest $request, int $productId,ProductUpdateService $service): JsonResponse
    {
        $data = ProductUpdateData::fromRequest($request);
        $data->id = $productId;
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->update($data);
        });
        return response()->json(['row_updated' => $result], ResponseAlias::HTTP_OK);
    }
}
