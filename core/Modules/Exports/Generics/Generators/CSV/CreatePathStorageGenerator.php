<?php

namespace Core\Modules\Exports\Generics\Generators\CSV;

class CreatePathStorageGenerator
{
    public function generate(string $basePath, string $baseFileName, int $id, string $uniqueString): string
    {
        return sprintf(
            '%s/%s/%s_%s_%s.csv',
            $basePath,
            now()->format('Y-m-d'),
            $baseFileName,
            $id,
            $uniqueString
        );
    }
}