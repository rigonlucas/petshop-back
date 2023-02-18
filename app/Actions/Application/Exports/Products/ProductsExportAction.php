<?php

namespace App\Actions\Application\Exports\Products;

use App\Actions\BaseAction;
use App\Actions\Interfaces\Export\ExportInterface;
use App\Enums\Exports\ExportConfigEnum;
use App\Enums\Exports\StorageExportEnum;
use App\Enums\ProductsEnum;
use App\Models\User;
use App\Repository\Application\Exports\Products\ProductsRepository;
use App\Repository\interfaces\ExportQueryInterface;
use Illuminate\Support\Facades\Storage;

class ProductsExportAction extends BaseAction implements ExportInterface
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

    public function export(User $user): array
    {
        $productsQuery = new ProductsRepository($user);
        $outputBuffer = $this->setHeaders();
        $outputBuffer = $this->createFile($productsQuery, $outputBuffer);
        return $this->getFileGenerator($user, $outputBuffer);
    }

    public function setHeaders(): mixed
    {
        $outputBuffer = fopen('php://temp/maxmemory:' . ExportConfigEnum::MEMORY_MAX_CSV->value, 'r+');

        if (ob_get_contents()) {
            ob_end_clean();
        }
        fputcsv($outputBuffer, $this->header_args);

        return $outputBuffer;
    }

    public function createFile(ExportQueryInterface $exportQuery, mixed $outputBuffer): mixed
    {
        foreach ($exportQuery->getQuery()->cursor() as $product) {
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
            fputcsv($outputBuffer, $dados);
        }
        return $outputBuffer;
    }

    public function getFileGenerator(User $user, mixed $outputBuffer): array
    {
        $zipFile = StorageExportEnum::PRODUCTS_FILE_NAME_BASE->getFileName();
        $path = StorageExportEnum::PRODUCTS_PATH->getPath($user->account->uuid);

        Storage::disk(StorageExportEnum::PRIVATE_DISK->value)->put(
            $path . $zipFile . '.csv',
            $outputBuffer
        );
        fclose($outputBuffer);

        return [
            'path' => $path,
            'file_name' => $zipFile . '.csv',
            'disk' => StorageExportEnum::PRIVATE_DISK->value
        ];
    }
}