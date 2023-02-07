<?php

namespace App\Http\Controllers\Products\Export;

use App\Http\Controllers\Controller;
use App\Jobs\Products\ProductsExportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsExportController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        ProductsExportJob::dispatch($request->user()->load('account:id,uuid'));
        return response()->json();
    }
}
