<?php

namespace App\Http\Controllers\Products\Product;

use App\Actions\Application\Products\DTO\ProductShowData;
use App\Actions\Application\Products\ProductShowAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;

class ProductShowController extends Controller
{
    public function __invoke(Request $request, int $id, ProductShowAction $service): ProductResource
    {
        $data = ProductShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        return ProductResource::make($service->show($data));
    }
}
