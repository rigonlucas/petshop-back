<?php

namespace App\Services\Application\Exports\Products;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsExportService
{
    private const FILE_NAME_BASE = 'produtos_';

    public function export(User $user): void
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
            ->where('account_id', '=', $user->account_id);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        //$output = fopen( 'php://output', 'w' );
        $output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

        if (ob_get_contents()) ob_end_clean();
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
        $accountPathOnStorage = $user->account_id . '/products/' . now()->format('Y-m-d') . '/';
        Storage::disk('public')->put(
            $accountPathOnStorage . self::FILE_NAME_BASE. Str::random(4) . '.csv', $output
        );
    }
}