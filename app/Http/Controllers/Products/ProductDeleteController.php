<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\Application\Products\ProductDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductDeleteController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(
        Request $request,
        int $id,
        ProductDeleteService $service,
    ): Response
    {
        $data = new ProductDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
