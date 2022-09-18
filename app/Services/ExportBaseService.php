<?php

namespace App\Services;

use App\Enums\Exports\StorageExportEnum;
use Illuminate\Support\Facades\Storage;

class ExportBaseService
{
    protected function csvHeader($header_args): mixed
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');


        if (ob_get_contents()) ob_end_clean();
        fputcsv($output, $header_args);

        return $output;
    }

    protected function storeFile(string $file, mixed $output): bool
    {
        return Storage::disk('public')->put(
            $file,
            $output
        );
    }
}