<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Application\Products\DTO\ProductShowData;
use App\Services\Application\Products\ProductShowService;
use Illuminate\Http\Request;

class ProductShowController extends Controller
{
    public function __invoke(Request $request, int $id, ProductShowService $service): ProductResource
    {
        $data = ProductShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        return ProductResource::make($service->show($data));
    }
}
