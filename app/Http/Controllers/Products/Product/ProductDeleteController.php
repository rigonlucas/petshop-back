<?php

namespace App\Http\Controllers\Products\Product;

use App\Actions\Application\Products\DTO\ProductDeleteData;
use App\Actions\Application\Products\ProductDeleteAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductDeleteController extends Controller
{
    public function __invoke(
        Request $request,
        int $id,
        ProductDeleteAction $service,
    ): Response
    {
        $data = new ProductDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
