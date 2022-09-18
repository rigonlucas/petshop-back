<?php

namespace App\Services\Application\Exports\Products;

use App\Enums\Exports\StorageExportEnum;
use App\Enums\ProductsEnum;
use App\Models\User;
use App\Notifications\Products\ExportProductsNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProductsExportService
{
    public function export(User $user): void
    {
        $header_args = [
            'id',
            'nome',
            'ocorrência em agendamentos',
            'tipo',
            'tipo_nome',
            'custo',
            'preço',
            'descrição',
        ];
        $products =  DB::table('products')
            ->select([
                'products.id',
                'products.name',
                'products.description',
                'products.type',
                'products.cost',
                'products.price',
            ])
            ->addSelect(DB::raw('count(schedules_has_products.id) as products_schedule_count'))
            ->leftJoin(
                'schedules_has_products',
                'products.id',
                '=',
                'schedules_has_products.product_id'
            )
            ->where('account_id', '=', $user->account_id)
            ->groupBy('products.id');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

        if (ob_get_contents()) ob_end_clean();
        fputcsv($output, $header_args);

        foreach($products->cursor() AS $product){
            $dados = [
                'id' => $product->id,
                'nome' => $product->name,
                'ocorrência em agendamentos' => $product->products_schedule_count,
                'tipo' => $product->type,
                'tipo_nome' => ProductsEnum::from($product->type)->name,
                'custo' => $product->cost,
                'preço' => $product->price,
                'descrição' => $product->description,
            ];
            fputcsv($output, $dados);
        }
        $file = StorageExportEnum::PRODUCTS_PATH->pathFileGenerator(
            $user->account->uuid,
            StorageExportEnum::PRODUCTS_FILE_NAME_BASE,
            'csv'
        );
        Storage::disk('public')->put(
            $file,
            $output
        );

        Notification::route('mail' , $user->email)->notify(new ExportProductsNotify($user, $file));
    }
}