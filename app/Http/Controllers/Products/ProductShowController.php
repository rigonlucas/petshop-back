<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductShowRequest;
use App\Http\Requests\Application\Product\ProductStoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\Application\Products\DTO\ProductShowData;
use App\Services\Application\Products\DTO\ProductUpdateData;
use App\Services\Application\Products\ProductShowService;
use App\Services\Application\Products\ProductUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductShowController extends Controller
{
    public function __invoke(Request $request, int $productId, ProductShowService $service): ProductResource
    {
        $data = ProductShowData::fromRequest($request);
        $data->id = $productId;
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->show($data);
        });
        return ProductResource::make($result);
    }
}
