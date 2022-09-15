<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Jobs\Products\ProductsExportJob;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function __invoke(Request $request)
    {
        $header_args = [
            'id',
            'name',
            'description',
            'type',
            'cost',
            'price'
        ];
        $products = DB::table('products')
            ->select([
                'products.id',
                'products.name',
                'products.description',
                'products.type',
                'products.cost',
                'products.price',
            ])
            ->where('account_id', '=', $request->user()->account_id);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $output = fopen( 'php://output', 'w' );

        ob_end_clean();
        fputcsv($output, $header_args);

        foreach($products->cursor() AS $product){
            $dados = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
                'cost' => $product->cost,
                'price' => $product->price,
            ];
            fputcsv($output, $dados);
        }
        return response()->noContent();
        /*
         * JOB
            $this->authorize('product_export');
            ProductsExportJob::dispatch($request->user());
            return response()->noContent();
         */
    }
}
