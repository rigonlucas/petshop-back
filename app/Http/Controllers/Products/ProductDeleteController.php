<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Product\ProductDeleteRequest;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\Application\Products\ProductDeleteService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductDeleteController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(ProductDeleteRequest $request, int $productId, ProductDeleteService $service): Response
    {
        $data = ProductDeleteData::fromRequest($request);
        $data->id = $productId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
