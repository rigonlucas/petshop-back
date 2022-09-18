<?php

namespace App\Http\Controllers\Products\Product;

use App\Http\Controllers\Controller;
use App\Services\Application\Products\DTO\ProductRestoreData;
use App\Services\Application\Products\ProductRestoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductRestoreController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ProductRestoreService $service
     * @return Response
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, ProductRestoreService $service): Response
    {
        $this->authorize('product_restore');
        $data = new ProductRestoreData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        DB::transaction(function () use ($service, $data) {
            $service->restore($data);
        });
        return response()->noContent();
    }
}
