<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Jobs\Products\ProductsExportJob;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->authorize('product_export');
        ProductsExportJob::dispatch($request->user()->load('account'));
        return response()->json();
    }
}

/*
$scheduleProducst = DB::table('schedules_has_products')
            ->whereColumn('products.id', '=', 'schedules_has_products.product_id')
            ->count();
        dd($scheduleProducst);
        $products = DB::table('products')
            ->select([
                'products.id',
                'products.name',
                'products.description',
                'products.type',
                'products.cost',
                'products.price',
            ])
            ->selectSub($scheduleProducst, 'count')
//            ->selectSub("
//                    SELECT
//                        COUNT(shp.id)
//                    FROM
//                        schedules_has_products shp
//                    WHERE
//                        shp.product_id = products.id")
->where('account_id', '=', 1)
    ->limit(1)
    ->get();
dd(
    $products
);


 */
