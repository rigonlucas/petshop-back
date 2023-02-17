<?php

namespace Core\Modules\Exports\Generics\Generators\CSV;

use Core\Modules\Exports\Generics\Enums\ExportacaoConfigEnum;

class CreateBufferGenerator
{
    public function generate(string $tempFileName, array $headers)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export_' . rand(0, 1000) . $tempFileName);

        $csvBuffer = fopen('php://temp/maxmemory:' . ExportacaoConfigEnum::TAMANHO_DO_MAX_CSV, 'r+');

        if (ob_get_contents()) {
            ob_end_clean();
        }
        fputcsv($csvBuffer, $headers);

        return $csvBuffer;
    }
}