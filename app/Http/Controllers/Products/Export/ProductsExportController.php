<?php

namespace App\Http\Controllers\Products\Export;

use App\Http\Controllers\Controller;
use App\Jobs\Products\ProductsExportJob;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsExportController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('product_export');
        ProductsExportJob::dispatch($request->user()->load('account:id,uuid'));
        return response()->json();
    }
}
