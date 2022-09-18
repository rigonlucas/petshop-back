<?php

namespace App\Enums\Exports;

use Illuminate\Support\Str;

enum StorageExportEnum: string
{
    /**
     * Return path to store files
     *
     * @param string $accountId
     * @param StorageExportEnum $enum
     * @param $extension
     * @return string
     */
    public function pathFileGenerator(string $accountId, StorageExportEnum $enum, $extension): string
    {
        $fileName = $enum->value . Str::random(4) . '.' .$extension;
        $accountValuesSearch = [
            ':ACCOUNT_ID:',
            ':DATE:'
        ];
        $accountValuesReplace = [
            $accountId,
            now()->format('Y-m-d')
        ];

        return str_replace($accountValuesSearch, $accountValuesReplace, $this->value) . $fileName;
    }


    /**
     * Files names
     */
    case PRODUCTS_FILE_NAME_BASE = 'produtos_';


    /**
     * Path
     */
    case PRODUCTS_PATH = 'accounts/:ACCOUNT_ID:/products/:DATE:/';
}
