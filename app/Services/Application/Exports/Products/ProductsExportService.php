<?php

namespace App\Services\Application\Exports\Products;

use App\Enums\Exports\StorageExportEnum;
use App\Enums\ProductsEnum;
use App\Models\User;
use App\Notifications\Products\ExportProductsNotify;
use App\Repository\Application\Exports\Products\ProductsRepository;
use App\Repository\Application\Exports\Schedules\SchedulesByStatusRepository;
use App\Repository\interfaces\ExportQueryInterface;
use App\Services\Application\Exports\ExportationManager\CreateManagerFilesService;
use App\Services\BaseService;
use App\Services\Interfaces\Export\ExportInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProductsExportService extends BaseService implements ExportInterface
{
    private array $header_args = [
        'id',
        'nome',
        'ocorrência em agendamentos',
        'tipo',
        'tipo_nome',
        'custo',
        'preço',
        'descrição',
    ];

    public function export(User $user): void
    {
        $productsQuery =  new ProductsRepository($user);
        $output = $this->setHeaders();
        $output = $this->createFile($productsQuery, $output);
        $filePath = $this->getFileGenerator($user, $output);
        if ($filePath) {
            Notification::route('mail' , $user->email)->notify(new ExportProductsNotify($user, $filePath));
            CreateManagerFilesService::create(
                $user,
                $this->shortNameClass(),
                $filePath
            );
        }
    }

    public function setHeaders(): mixed
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

        if (ob_get_contents()) ob_end_clean();
        fputcsv($output, $this->header_args);

        return $output;
    }

    public function createFile(ExportQueryInterface $exportQuery, mixed $output): mixed
    {
        foreach($exportQuery->getQuery()->cursor() AS $product){
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
        return $output;
    }

    public function getFileGenerator(User $user, mixed $output): string
    {
        $file = StorageExportEnum::PRODUCTS_PATH->pathFileGenerator(
            $user->account->uuid,
            StorageExportEnum::PRODUCTS_FILE_NAME_BASE,
            'csv'
        );
        Storage::disk('public')->put(
            $file,
            $output
        );

        return $file;
    }
}