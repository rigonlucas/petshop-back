<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\Application\Products\ProductDeleteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ProductDeleteService $service
     * @return Response
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(
        Request $request,
        int $id,
        ProductDeleteService $service,
    ): Response
    {
        $this->authorize('product_delete');
        $data = new ProductDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
